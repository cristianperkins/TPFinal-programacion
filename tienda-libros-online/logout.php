<?php
// Iniciar la sesión (si no está iniciada ya)
session_start();

// Borrar todas las variables de sesión
session_unset();

// Destruir la sesión (borra todos los datos de sesión del servidor)
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header("Location: login.php");

// Finalizar la ejecución del script para evitar que se procese más código
exit;
?>