<?php
session_start();

// Incluye el archivo de conexión a la base de datos
include "../db_conexion.php";

class GestorLibro {
    private $conn;

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function estaAutenticado() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
    }

    public function redirigirALogin() {
        header("Location: ../login.php");
        exit;
    }

    public function agregarLibro($titulo, $autor_id, $descripcion, $categoria_id, $portada, $anio_publicacion, $precio) {
        if (empty($titulo) || empty($autor_id) || empty($descripcion) || empty($categoria_id) || empty($portada) || empty($anio_publicacion) || empty($precio)) {
            $mensaje_error = "Todos los campos son requeridos";
        } else {
            $sql  = "INSERT INTO libros (titulo, autor_id, descripcion, categoria_id, portada, anio_publicacion, precio) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $resultado  = $stmt->execute([$titulo, $autor_id, $descripcion, $categoria_id, $portada, $anio_publicacion, $precio]);

            if ($resultado) {
                // Libro añadido con éxito
                $mensaje_exito = "Libro añadido con éxito";
            } else {
                // Error al agregar el libro
                $mensaje_error = "Error al agregar el libro";
            }
        }

        // Redirige de nuevo a la página con los mensajes
        if (isset($mensaje_error)) {
            header("Location: ../anadir-libro.php?error=$mensaje_error");
        } elseif (isset($mensaje_exito)) {
            header("Location: ../anadir-libro.php?success=$mensaje_exito");
        }
        exit;
    }

    public function redirigiraAdmin() {
        header("Location: ../viewsMenuAdministrador.php");
        exit;
    }
}

// Verificar autenticación
$gestorLibro = new GestorLibro($conn);

if (!$gestorLibro->estaAutenticado()) {
    $gestorLibro->redirigirALogin();
}

// Procesar el formulario para agregar un libro
if (isset($_POST['titulo']) && isset($_POST['autor_id']) && isset($_POST['descripcion']) && isset($_POST['categoria_id']) && isset($_POST['portada']) && isset($_POST['anio_publicacion']) && isset($_POST['precio'])) {
    $titulo = $_POST['titulo'];
    $autor_id = $_POST['autor_id'];
    $descripcion = $_POST['descripcion'];
    $categoria_id = $_POST['categoria_id'];
    $portada = $_POST['portada'];
    $anio_publicacion = $_POST['anio_publicacion'];
    $precio = $_POST['precio'];
    $gestorLibro->agregarLibro($titulo, $autor_id, $descripcion, $categoria_id, $portada, $anio_publicacion, $precio);
} else {
    $gestorLibro->redirigiraAdmin();
}
?>