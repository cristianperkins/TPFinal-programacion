<?php
require('../config/db_conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreUsuario = $_POST['username'];
    $correoElectronico = $_POST['email'];
    $confirmEmail = $_POST['confirm-email'];
    $contrasena = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $fechaNacimiento = $_POST['birthdate'];
    $telefono = $_POST['phone'];

    if (!empty($nombreUsuario) && !empty($correoElectronico) && !empty($confirmEmail) && !empty($contrasena) && !empty($fechaNacimiento) && !empty($telefono)) {
        $anioNacimiento = date('Y', strtotime($fechaNacimiento));
        $anioActual = date('Y');
        $edad = $anioActual - $anioNacimiento;

        try {
            // Prepara la consulta para insertar el usuario en la base de datos
            $stmt = $conn->prepare('INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena, fecha_nacimiento, telefono) VALUES (:nombreUsuario, :correoElectronico, :contrasena, :fechaNacimiento, :telefono)');
            $stmt->bindParam(':nombreUsuario', $nombreUsuario);
            $stmt->bindParam(':correoElectronico', $correoElectronico);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->execute();

            // Redirecciona al usuario a index.php después del registro exitoso
            header('Location: ../index.php');

            // Sal de la ejecución después de la redirección
            exit();
        } catch (PDOException $e) {
            // Maneja cualquier error que pueda ocurrir al registrar al usuario
            $errors[] = "Error al registrar usuario: " . $e->getMessage();
        }
    }
}
?>