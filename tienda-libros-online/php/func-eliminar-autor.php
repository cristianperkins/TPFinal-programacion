<?php
session_start();

# Verifica si el administrador está autenticado
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    # Verifica si se proporciona el ID del autor a eliminar
    if (isset($_GET['id'])) {
        $autor_id = $_GET['id'];

        # Incluye el archivo de conexión a la base de datos
        include "../db_conexion.php";

        # Realiza la lógica para eliminar el autor de la base de datos
        $sql = "DELETE FROM autor WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $resultado = $stmt->execute([$autor_id]);

        if ($resultado) {
            # Redirige a la página de administrador con un mensaje de éxito
            header("Location: ../admin.php?success=Autor eliminado exitosamente");
            exit;
        } else {
            # Redirige a la página de administrador con un mensaje de error si la eliminación falla
            header("Location: ../admin.php?error=Error al eliminar el autor");
            exit;
        }
    } else {
        header("Location: ../admin.php?error=ID de autor no proporcionado");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}