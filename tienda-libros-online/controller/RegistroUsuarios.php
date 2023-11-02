<?php
class RegistroUsuarios {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario($nombreUsuario, $correoElectronico, $confirmEmail, $contrasena, $fechaNacimiento, $telefono) {
        $errors = [];

        // Validación de datos
        if (empty($nombreUsuario) || empty($correoElectronico) || empty($confirmEmail) || empty($contrasena) || empty($fechaNacimiento) || empty($telefono)) {
            $errors[] = "No puedes dejar los campos vacíos, por favor ingresa los datos requeridos.";
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $nombreUsuario) || preg_match('/^[0-9]/', $nombreUsuario)) {
            $errors[] = "El nombre de usuario no puede contener símbolos ni comenzar con números.";
        }

        if (!filter_var($correoElectronico, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        }

        if ($correoElectronico !== $confirmEmail) {
            $errors[] = "La confirmación de correo electrónico no coincide con el correo electrónico.";
        }

        $anioNacimiento = date('Y', strtotime($fechaNacimiento));
        $anioActual = date('Y');
        $edad = $anioActual - $anioNacimiento;

        if ($anioNacimiento < 1915 || $anioNacimiento > 2023) {
            $errors[] = "Selecciona una fecha de nacimiento válida.";
        } else if ($edad < 18) {
            $errors[] = "Eres menor de edad, no tienes permitido crear una cuenta.";
        }

        if (!preg_match('/^\d{10,}$/', $telefono)) {
            $errors[] = "Ingresa un número de teléfono válido (al menos 10 dígitos numéricos).";
        }

        // Si no hay errores, registramos al usuario
        if (empty($errors)) {
            // Hashear la contraseña
            $contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

            $usuarios = new Usuarios($this->conn);
            $registroExitoso = $usuarios->registrarUsuario($nombreUsuario, $correoElectronico, $contrasena, $fechaNacimiento, $telefono);

            if ($registroExitoso) {
                return "Registro exitoso";
            } else {
                $errors[] = "Error al registrar el usuario en la base de datos.";
            }
        }

        return $errors;
    }
}
?>