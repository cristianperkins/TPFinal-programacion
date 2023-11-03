<?php
session_start();

include "../config/db_conexion.php";
include "../models/EliminarLibro.php";

class LibroController {
    public function eliminarLibro($conn, $libroId) {
        $eliminarLibro = new EliminarLibro($conn);
        $resultado = $eliminarLibro->eliminarLibro($libroId);
        return $resultado;
    }
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_POST['libro_id'])) {
        $libro_id = $_POST['libro_id'];

        $libroController = new LibroController();
        $resultado = $libroController->eliminarLibro($conn, $libro_id);

        if ($resultado) {
            header("Location: ../views/MenuAdministrador.php?success=Libro eliminado exitosamente");
            exit;
        } else {
            header("Location: ../views/MenuAdministrador.php?error=Error al eliminar el libro");
            exit;
        }
    } else {
        header("Location: ../views/MenuAdministrador.php?error=ID de libro no proporcionado");
        exit;
    }
} else {
    header("Location: ../views/Login.php");
    exit;
}