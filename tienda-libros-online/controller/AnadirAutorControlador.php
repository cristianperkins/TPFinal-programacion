<?php
session_start();

// Verificamos la autenticación del usuario
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../views/Login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../models/AddAutor.php');

    $authorManager = new AuthorManager();

    if (isset($_POST['nombre_autor']) && isset($_POST['apellido_autor'])) {
        $nombre_autor = $_POST['nombre_autor'];
        $apellido_autor = $_POST['apellido_autor'];

        if (empty($nombre_autor) && empty($apellido_autor)) {
            header("Location: ../views/AnadirAutor.php?error=El nombre y el apellido del autor son necesarios");
            exit;
        } elseif (empty($nombre_autor)) {
            header("Location: ../views/AnadirAutor.php?error=El nombre es necesario");
            exit;
        }

        $result = $authorManager->agregarAutor($nombre_autor, $apellido_autor);

        if ($result === "Autor añadido con éxito") {
            header("Location: ../views/AnadirAutor.php?success=Autor añadido con éxito");
            exit;
        }
    }
} else {
    header("Location: ../views/MenuAdministrador.php");
    exit;
}
?>