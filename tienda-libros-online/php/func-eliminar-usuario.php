<?php
session_start();

# Verificamos la autenticación del usuario
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../login.php");
    exit;
}

# Verifica si se proporciona el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    # Incluye el archivo de conexión a la base de datos
    include "../db_conexion.php";

    # Realiza la lógica para eliminar al usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $resultado = $stmt->execute([$usuario_id]);

    if ($resultado) {
        # Redirige de vuelta a la lista de usuarios con un mensaje de éxito
        header("Location: ../lista-usuarios.php?success=Usuario%20eliminado%20exitosamente");
        exit;
    } else {
        # Redirige de vuelta a la lista de usuarios con un mensaje de error si la eliminación falla
        header("Location: ../lista-usuarios.php?error=Error al eliminar el usuario");
        exit;
    }
} else {
    header("Location: lista-usuarios.php?error=ID de usuario no proporcionado");
    exit;
}
?>