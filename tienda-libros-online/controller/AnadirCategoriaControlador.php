<?php
session_start();

// Incluye el archivo de conexión a la base de datos
include '../config/db_conexion.php';

class CategoriaController {
    private $conn;

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function estaAutenticado() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
    }

    public function redirigirALogin() {
        header("Location: ../views/Login.php");
        exit;
    }

    public function redirigiraAdmin($mensaje = null) {
        if (isset($mensaje)) {
            header("Location: ../views/AnadirCategoria.php?mensaje=" . urlencode($mensaje));
        } else {
            header("Location: ../views/MenuAdministrador.php");
        }
        exit;
    }
}

// Verificar autenticación
$categoriaController = new CategoriaController($conn);

if (!$categoriaController->estaAutenticado()) {
    $categoriaController->redirigirALogin();
}

// Procesar el formulario para agregar una categoría
if (isset($_POST['nombre_categoria'])) {
    $nombre_categoria = $_POST['nombre_categoria'];

    // Incluye el modelo
    include "../models/AddCategoria.php";
    $categoriaModel = new CategoriaModel($conn);
    $mensaje = $categoriaModel->agregarCategoria($nombre_categoria);

    $categoriaController->redirigiraAdmin($mensaje);
} else {
    $categoriaController->redirigiraAdmin();
}
?>