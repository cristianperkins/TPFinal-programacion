<?php
session_start();

# Verificamos la autenticación del usuario
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: ../login.php");
    exit;
}

# Incluye el archivo de conexión a la base de datos
include "../db_conexion.php";

# Verifica si se proporciona el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    # Incluye el modelo Usuarios
    include "../models/UsuarioConsultas.php";

    # Crea una instancia del modelo Usuarios
    $modeloUsuarios = new Usuarios($conn);

    # Intenta eliminar al usuario
    if ($modeloUsuarios->eliminarUsuario($usuario_id)) {
        # Redirigimos de vuelta a la lista de usuarios con un mensaje de éxito
        header("Location: ../views/ListaUsuarios.php?success=Usuario eliminado exitosamente");
        exit;
    } else {
        # Redirigimos de vuelta a la lista de usuarios con un mensaje de error si la eliminación falla
        header("Location: ../views/ListaUsuarios.php?error=Error al eliminar el usuario");
        exit;
    }
} else {
    header("Location: ../views/ListaUsuarios.php?error=ID de usuario no proporcionado");
    exit;
}
?>