<?php
session_start();

include "../db_conexion.php";
include "../models/EliminarCategoria.php";

class CategoriaController {
    public function eliminarCategoria($conn, $categoriaId) {
        $eliminarCategoria = new EliminarCategoria($conn);
        $resultado = $eliminarCategoria->eliminarCategoria($categoriaId);
        return $resultado;
    }
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_GET['id'])) {
        $categoria_id = $_GET['id'];

        $categoriaController = new CategoriaController();
        $resultado = $categoriaController->eliminarCategoria($conn, $categoria_id);

        if ($resultado) {
            header("Location: ../views/MenuAdministrador.php?success=Categoría eliminada exitosamente");
            exit;
        } else {
            header("Location: ../views/MenuAdministrador.php?error=Error al eliminar la categoría");
            exit;
        }
    } else {
        header("Location: ../views/MenuAdministrador.php?error=ID de categoría no proporcionado");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}


?>