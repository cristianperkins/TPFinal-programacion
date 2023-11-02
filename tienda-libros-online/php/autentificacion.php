<?php
// Incluye el archivo que nos conecta con la base de datos
include "../db_conexion.php";

// Incluye el archivo que contiene la clase de validación de formularios
include "func-validacion.php";

// Verifica si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crea una instancia de la clase FormValidation
    $FormValidacion = new FormValidacion();
    
    // Obtiene los valores de email y contraseña del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Inicializa un mensaje de error vacío
    $errorMensaje = "";

    // Valida si el campo de email está vacío y almacena el mensaje de error (si existe)
    $emailError = $FormValidacion->isEmpty($email, "E-mail");

    // Valida si el campo de contraseña está vacío y almacena el mensaje de error (si existe)
    $passwordError = $FormValidacion->isEmpty($password, "contraseña");
    
    // Comprueba si ambos campos están vacíos
    if ($emailError && $passwordError) {
        // Si ambos campos están vacíos, muestra un mensaje que hace referencia a ambos
        $errorMensaje = "Son necesarios un E-mail y una contraseña.";
    } elseif ($emailError) {
        // Si solo el Email está vacío, muestra un mensaje de error
        $errorMensaje = "Es necesario un E-mail.";
    } elseif ($passwordError) {
        // Si solo la contraseña está vacía, muestra un mensaje de error
        $errorMensaje = "Es necesaria una contraseña.";
    } else {
        // Valida si el correo electrónico está en la base de datos de administradores
        $sql = "SELECT * FROM admin WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() === 1) {
            // Si el Email se encuentra en la base de datos de administradores, no importa la contraseña
            session_start();
            $user = $stmt->fetch();
            $user_id = $user['id'];
            $user_email = $user['email'];
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $user_email;
            header("Location: ../views/MenuAdministrador.php");
            exit;
        } else {
            // Si el Email no se encuentra en la base de datos de administradores, verifica si es un usuario registrado
            $sql = "SELECT * FROM usuarios WHERE correo_electronico=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);

            if ($stmt->rowCount() === 1) {
                // Si el Email se encuentra en la base de datos de usuarios registrados, verifica la contraseña
                $user = $stmt->fetch();
                echo 'Contraseña ingresada: ' . $password . '<br>';
                echo 'Hash almacenado en la base de datos: ' . $user['contrasena'] . '<br>';
                if (password_verify($password, $user['contrasena'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['correo_electronico'];
                    header("Location: ../index.php");
                    exit;
                } else {
                    $errorMensaje = "Contraseña incorrecta.";
                }
            } else {
                $errorMensaje = "El E-mail no figura en nuestra base de datos.";
            }
        }
    }
}

// Redirige de vuelta a la página de inicio de sesión con el mensaje de error (si existe)
header("Location: ../login.php?error=" . urlencode($errorMensaje));
exit;
?>