<?php
session_start();

// Incluye el archivo de conexión a la base de datos
include "../db_conexion.php";

class GestorAutor {
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

    public function agregarAutor($nombre_autor, $apellido_autor) {
        if (empty($nombre_autor) && empty($apellido_autor)) {
            $mensaje_error = "Tanto el nombre como el apellido del autor son requeridos";
        } elseif (empty($nombre_autor)) {
            $mensaje_error = "El nombre del autor es requerido";
        } elseif (empty($apellido_autor)) {
            $mensaje_error = "El apellido del autor es requerido";
        } else {
            $sql  = "INSERT INTO autor (nombre, apellido) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $resultado  = $stmt->execute([$nombre_autor, $apellido_autor]);

            if ($resultado) {
                // Autor añadido con éxito
                $mensaje_exito = "Autor añadido con éxito";
            } else {
                // Error al agregar autor
                $mensaje_error = "Error al agregar autor";
            }
        }

        // Redirige de nuevo a la página con los mensajes
        if (isset($mensaje_error)) {
            header("Location: ../anadir-autor.php?error=$mensaje_error");
        } elseif (isset($mensaje_exito)) {
            header("Location: ../anadir-autor.php?success=$mensaje_exito");
        }
        exit;
    }

    public function redirigiraAdmin() {
        header("Location: ../admin.php");
        exit;
    }
}

// Verificar autenticación
$gestorAutor = new GestorAutor($conn);

if (!$gestorAutor->estaAutenticado()) {
    $gestorAutor->redirigirALogin();
}

// Procesar el formulario para agregar un autor
if (isset($_POST['nombre_autor']) && isset($_POST['apellido_autor'])) {
    $nombre_autor = $_POST['nombre_autor'];
    $apellido_autor = $_POST['apellido_autor'];
    $gestorAutor->agregarAutor($nombre_autor, $apellido_autor);
} else {
    $gestorAutor->redirigiraAdmin();
}
?>