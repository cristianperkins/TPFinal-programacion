<?php
session_start();

// Incluye el archivo de conexión a la base de datos
include "../db_conexion.php";

class GestorCategoria {
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

    public function agregarCategoria($nombre_categoria) {
        if (empty($nombre_categoria)) {
            $mensaje_error = "El nombre de la categoría es requerido";
        } else {
            $sql  = "INSERT INTO categorias (nombre) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $resultado  = $stmt->execute([$nombre_categoria]);

            if ($resultado) {
                // Categoría añadida con éxito
                $mensaje_exito = "Categoría añadida con éxito";
            } else {
                // Error al agregar categoría
                $mensaje_error = "Error al agregar categoría";
            }
        }

        // Redirige de nuevo a la página con los mensajes
        if (isset($mensaje_error)) {
            header("Location: ../anadir-categoria.php?error=$mensaje_error");
        } elseif (isset($mensaje_exito)) {
            header("Location: ../anadir-categoria.php?success=$mensaje_exito");
        }
        exit;
    }

    public function redirigiraAdmin() {
        header("Location: ../admin.php");
        exit;
    }
}

// Verificar autenticación
$gestorCategoria = new GestorCategoria($conn);

if (!$gestorCategoria->estaAutenticado()) {
    $gestorCategoria->redirigirALogin();
}

// Procesar el formulario para agregar una categoría
if (isset($_POST['nombre_categoria'])) {
    $nombre_categoria = $_POST['nombre_categoria'];
    $gestorCategoria->agregarCategoria($nombre_categoria);
} else {
    $gestorCategoria->redirigiraAdmin();
}
?>