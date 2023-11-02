<?php
session_start();
include "../db_conexion.php";
include "../models/EditarCategoria.php"; // Requiere el modelo
$categoriaModel = new CategoriaModel($conn);

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_POST['nombre_categoria']) && isset($_POST['categoria_id'])) {
        $errorOrSuccessMsg = $categoriaModel->updateCategory($_POST['nombre_categoria'], $_POST['categoria_id']);
        if (strpos($errorOrSuccessMsg, 'Error') !== false) {
            header("Location: ../views/EditarCategoriaFormulario.php?error=" . urlencode($errorOrSuccessMsg) . "&id=" . $_POST['categoria_id']);
        } else {
            header("Location: ../views/EditarCategoriaFormulario.php?success=" . urlencode($errorOrSuccessMsg) . "&id=" . $_POST['categoria_id']);
        }
        exit;
    } else {
        header("Location: ../views/MenuAdministrador.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>