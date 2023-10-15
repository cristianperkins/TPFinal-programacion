<?php
session_start();

# Verifica si el administrador está autenticado
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    # Verifica si se proporciona el ID de la categoría a eliminar
    if (isset($_GET['id'])) {
        $categoria_id = $_GET['id'];

        # Incluye el archivo de conexión a la base de datos
        include "../db_conexion.php";

        # Realiza la lógica para eliminar la categoría de la base de datos
        $sql = "DELETE FROM categorias WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $resultado = $stmt->execute([$categoria_id]);

        if ($resultado) {
            # Redirige a la página de administrador con un mensaje de éxito
            header("Location: ../admin.php?success=Categoría eliminada exitosamente");
            exit;
        } else {
            # Redirige a la página de administrador con un mensaje de error si la eliminación falla
            header("Location: ../admin.php?error=Error al eliminar la categoría");
            exit;
        }
    } else {
        header("Location: ../admin.php?error=ID de categoría no proporcionado");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}