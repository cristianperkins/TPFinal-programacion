<?php
session_start();

# Verifica si el administrador está autenticado
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    # Verifica si se proporciona el ID del libro a eliminar
    if (isset($_POST['libro_id'])) {
        $libro_id = $_POST['libro_id'];

        # Incluye el archivo de conexión a la base de datos
        include "../db_conexion.php";

        # Esta es la lógica para eliminar un libro sin afectar a las tablas de autor o categorías
        $sql = "DELETE FROM libros WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $resultado = $stmt->execute([$libro_id]);

        if ($resultado) {
            # Redirige a la página de administrador con un mensaje de éxito al eliminar el libro
            header("Location: ../admin.php?success=Libro eliminado exitosamente");
            exit;
        } else {
            # Redirige a la página de administrador con un mensaje de error si la eliminación falla
            header("Location: ../admin.php?error=Error al eliminar el libro");
            exit;
        }
    } else {
        header("Location: ../admin.php?error=ID de libro no proporcionado");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}