<?php
require('db_conexion.php');
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreUsuario = $_POST['username'];
    $correoElectronico = $_POST['email'];
    $confirmEmail = $_POST['confirm-email'];
    $contrasena = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $fechaNacimiento = $_POST['birthdate'];
    $telefono = $_POST['phone'];

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

    if (empty($errors)) {
        try {
            // Prepararo la consulta para insertar el usuario en la base de datos
            $stmt = $conn->prepare('INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena, fecha_nacimiento, telefono) VALUES (:nombreUsuario, :correoElectronico, :contrasena, :fechaNacimiento, :telefono)');
            $stmt->bindParam(':nombreUsuario', $nombreUsuario);
            $stmt->bindParam(':correoElectronico', $correoElectronico);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->execute();

            // Regresamos  al usuario a index.php después del registro exitoso
            header('Location: index.php');

            // Exit para detener la ejecución después de la redirección
            exit();
        } catch (PDOException $e) {
            $errors[] = "Error al registrar usuario: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-iU3XAxK5ZzIFxTXz0a9Lz/QY5TIjbz/YH5uR5Q2C3JzWkPFFPvJx6ws4Dd+txvDFb" crossorigin="anonymous"></script>    <link rel="stylesheet" href="css/estilos-index-login.css">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Libros Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre-nosotros.php">Sobre Nosotros</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Registro de Usuario</h1>
        <form id="registration-form" method="POST" onsubmit="return validarFormulario();">
         <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username">
                <div class="alert alert-danger" role="alert" id="error-username" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="email" name="email">
                <div class="alert alert-danger" role="alert" id="error-email" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="confirm-email" class="form-label">Confirmación de E-mail</label>
                <input type="text" class="form-control" id="confirm-email" name="confirm-email">
                <div class="alert alert-danger" role="alert" id="error-confirm-email" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="alert alert-danger" role="alert" id="error-password" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate">
                <div class="alert alert-danger" role="alert" id="error-birthdate" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone">
                <div class="alert alert-danger" role="alert" id="error-phone" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Género</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="" selected>Selecciona tu género</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="no-binario">No binario</option>
                    </select>
            <div class="alert alert-danger" role="alert" id="error-gender" style="display: none;">Selecciona tu género.</div>
          </div>

            <div class="alert alert-danger" role="alert" id="error-message" style="display: none;"></div>

            <div id="registration-success" class="alert alert-success" role="alert" style="display: none;">
                Usuario registrado, bienvenido <span id="registered-username"></span>
                <button type="button" class="btn btn-success" onclick="redirigirAIndex()">Aceptar</button>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </form>
    </div>
</div>
<script>
   function redirigirAIndex() {
        window.location.href = 'index.php';
    }

    function mostrarAlert(nombreUsuario) {
    const genero = document.getElementById('gender').value;
    let mensaje = `Registro exitoso, Bienvenid${genero === 'femenino' ? 'a' : (genero === 'no-binario' ? 'e' : (genero === 'masculino' ? 'o' : ''))} ${nombreUsuario}`;
    alert(mensaje);
    redirigirAIndex();
}


    function validarFormulario() {
    const nombreUsuario = document.getElementById('username').value;
    const correoElectronico = document.getElementById('email').value;
    const confirmEmail = document.getElementById('confirm-email').value;
    const contrasena = document.getElementById('password').value;
    const fechaNacimiento = document.getElementById('birthdate').value;
    const telefono = document.getElementById('phone').value;
    const mensajeError = document.getElementById('error-message');
    const errorUsername = document.getElementById('error-username');
    const errorEmail = document.getElementById('error-email');
    const errorConfirmEmail = document.getElementById('error-confirm-email');
    const errorPassword = document.getElementById('error-password');
    const errorBirthdate = document.getElementById('error-birthdate');
    const errorPhone = document.getElementById('error-phone');
    const genero = document.getElementById('gender').value;
    const errorGenero = document.getElementById('error-gender');

    // Limpiamos los mensajes de errores previos

    errorUsername.style.display = 'none';
    errorEmail.style.display = 'none';
    errorConfirmEmail.style.display = 'none';
    errorPassword.style.display = 'none';
    errorBirthdate.style.display = 'none';
    errorPhone.style.display = 'none';
    errorGenero.style.display = 'none';  
    mensajeError.style.display = 'none';

    if (nombreUsuario.trim() === '') {
        errorUsername.textContent = "El nombre de usuario es obligatorio.";
        errorUsername.style.display = 'block';
    } else if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(nombreUsuario) || /^[0-9]/.test(nombreUsuario)) {
        errorUsername.textContent = "El nombre de usuario no puede contener símbolos ni comenzar con números.";
        errorUsername.style.display = 'block';
    }

    if (correoElectronico.trim() === '') {
        errorEmail.textContent = "El correo electrónico es obligatorio.";
        errorEmail.style.display = 'block';
    } else if (!/^[a-zA-Z]\S*@.+\.\S+/.test(correoElectronico)) {
        errorEmail.textContent = "El correo electrónico no es válido.";
        errorEmail.style.display = 'block';
    }

    if (confirmEmail.trim() === '') {
        errorConfirmEmail.textContent = "La confirmación de correo electrónico es obligatoria.";
        errorConfirmEmail.style.display = 'block';
    } else if (correoElectronico !== confirmEmail) {
        errorConfirmEmail.textContent = "La confirmación de correo electrónico no coincide con el correo electrónico.";
        errorConfirmEmail.style.display = 'block';
    }

    if (contrasena.trim() === '') {
        errorPassword.textContent = "La contraseña es obligatoria.";
        errorPassword.style.display = 'block';
    } else if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(contrasena) || /[@#$%^&*()_+!]/.test(contrasena) || contrasena.length < 10) {
        errorPassword.textContent = "La contraseña debe tener al menos 10 caracteres y no puede contener ciertos símbolos.";
        errorPassword.style.display = 'block';
    }

    if (fechaNacimiento.trim() === '') {
        errorBirthdate.textContent = "La fecha de nacimiento es obligatoria.";
        errorBirthdate.style.display = 'block';
    } else {
        const anioNacimiento = new Date(fechaNacimiento).getFullYear();
        const anioActual = new Date().getFullYear();
        const edad = anioActual - anioNacimiento;

        if (anioNacimiento < 1930 || anioNacimiento > 2023) {
            errorBirthdate.textContent = "Selecciona una fecha de nacimiento válida.";
            errorBirthdate.style.display = 'block';
        } else if (edad < 18) {
            errorBirthdate.textContent = "Eres menor de edad, no puedes crear una cuenta.";
            errorBirthdate.style.display = 'block';
        }
    }

    if (telefono.trim() === '') {
        errorPhone.textContent = "El número de teléfono es obligatorio.";
        errorPhone.style.display = 'block';
    } else if (!/^\d{10,}$/.test(telefono)) {
        errorPhone.textContent = "Ingresa un número de teléfono válido (al menos 10 dígitos numéricos).";
        errorPhone.style.display = 'block';
    }

    if (genero === '') {
        errorGenero.textContent = "Selecciona tu género.";
        errorGenero.style.display = 'block';
    }

    // Comprueba si se han mostrado mensajes de error
    if (
        errorUsername.style.display === 'block' ||
        errorEmail.style.display === 'block' ||
        errorConfirmEmail.style.display === 'block' ||
        errorPassword.style.display === 'block' ||
        errorBirthdate.style.display === 'block' ||
        errorPhone.style.display === 'block' ||
        errorGenero.style.display === 'block' // Asegúrate de incluir el error del género
    ) {
        mensajeError.textContent = "Por favor, corrige los errores antes de enviar el formulario.";
        mensajeError.style.display = 'block';
        return false;
    }

    // Mostrar mensaje de registro exitoso
    mostrarAlert(nombreUsuario);

    return true;
}

</script>
<!-- Incluye el archivo JavaScript de Bootstrap 5 al final del body para mejorar el rendimiento -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>