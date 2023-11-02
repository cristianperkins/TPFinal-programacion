<?php
session_start();

include "../db_conexion.php";
include "../models/EliminarAutor.php";

class AutorController {
    public function eliminarAutor($conn, $authorId) {
        $eliminarAutor = new EliminarAutor($conn);
        $resultado = $eliminarAutor->deleteAuthor($authorId);
        return $resultado;
    }
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_GET['id'])) {
        $autor_id = $_GET['id'];

        $autorController = new AutorController();
        $resultado = $autorController->eliminarAutor($conn, $autor_id);

        if ($resultado) {
            header("Location: ../views/MenuAdministrador.php?success=Autor eliminado exitosamente");
            exit;
        } else {
            header("Location: ../views/MenuAdministrador.php?error=Error al eliminar el autor");
            exit;
        }
    } else {
        header("Location: ../views/MenuAdministrador.php?error=ID de autor no proporcionado");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}