<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    if (isset($_POST['nombre_autor']) && isset($_POST['apellido_autor']) && isset($_POST['autor_id'])) {
        include "../config/db_conexion.php";
        include "../models/EditarAutor.php";
        $autorModel = new AutorEditor($conn);
        $errorOrSuccessMsg = $autorModel->updateAuthor($_POST['nombre_autor'], $_POST['apellido_autor'], $_POST['autor_id']);
        if (strpos($errorOrSuccessMsg, 'Error') !== false) {
            header("Location: ../views/EditarAutorFormulario.php?error=" . urlencode($errorOrSuccessMsg) . "&id=" . $_POST['autor_id']);
        } else {
            header("Location: ../views/EditarAutorFormulario.php?success=" . urlencode($errorOrSuccessMsg) . "&id=" . $_POST['autor_id']);
        }
        exit;
    } else {
        header("Location: ../views/MenuAdministrador.php.php");
        exit;
    }
} else {
    header("Location: ../views/Login.php");
    exit;
}
?>