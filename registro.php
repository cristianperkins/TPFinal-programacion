<?php
require('db_conexion.php'); // Incluye el archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obten los datos del formulario
    $nombreUsuario = $_POST['username'];
    $correoElectronico = $_POST['email'];
    $contrasena = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash de la contraseña
    $fechaNacimiento = $_POST['birthdate'];
    $telefono = $_POST['phone'];

    try {
        // Prepara la consulta SQL para insertar el nuevo usuario en la tabla "usuarios"
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena, fecha_nacimiento, telefono) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombreUsuario, $correoElectronico, $contrasena, $fechaNacimiento, $telefono]);

        // Redirige a una página de éxito o muestra un mensaje de registro exitoso
        header('Location: registro_exitoso.php'); // Reemplaza con la URL adecuada
        exit();
    } catch (PDOException $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/estilos-index-login.css">
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
    <h1>Registro de Usuario</h1>
    <form id="registration-form" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="mb-3">
            <label for "password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>

        <div class="alert alert-danger" role="alert" id="error-message" style="display: none;"></div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <button type="reset" class="btn btn-secondary">Limpiar</button>
    </form>
</div>
<script>
    function validarFormulario() {
        const nombreUsuario = document.getElementById('username').value;
        const correoElectronico = document.getElementById('email').value;
        const contrasena = document.getElementById('password').value;
        const fechaNacimiento = document.getElementById('birthdate').value;
        const telefono = document.getElementById('phone').value;
        const mensajeError = document.getElementById('error-message');

        if (nombreUsuario.trim() === '' || correoElectronico.trim() === '' || contrasena.trim() === '' || fechaNacimiento.trim() === '' || telefono.trim() === '') {
            mensajeError.textContent = "Todos los campos son obligatorios. Por favor, completa todos los campos.";
            mensajeError.style.display = 'block';
        } else if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(nombreUsuario) || /^[0-9]/.test(nombreUsuario)) {
            mensajeError.textContent = "El nombre de usuario no puede contener símbolos ni comenzar con números.";
            mensajeError.style.display = 'block';
        } else if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(contrasena) || /[@#$%^&*()_+!]/.test(contrasena) || contrasena.length < 10) {
            mensajeError.textContent = "La contraseña debe tener al menos 10 caracteres y no puede contener ciertos símbolos.";
            mensajeError.style.display = 'block';
        } else if (!/^[a-zA-Z]\S*@.+\.\S+/.test(correoElectronico)) {
            mensajeError.textContent = "El correo electrónico no es válido.";
            mensajeError.style.display = 'block';
        } else {
            const anioNacimiento = new Date(fechaNacimiento).getFullYear();
            const anioActual = new Date().getFullYear();
            const edad = anioActual - anioNacimiento;

            if (anioNacimiento < 1930 || anioNacimiento > 2023) {
                mensajeError.textContent = "Selecciona una fecha de nacimiento válida.";
                mensajeError.style.display = 'block';
            } else if (anioNacimiento > 2005) {
                mensajeError.textContent = "Eres menor de edad.";
                mensajeError.style.display = 'block';
            } else if (!/^\d{10,}$/.test(telefono)) {
                mensajeError.textContent = "Ingresa un número de teléfono válido (al menos 10 dígitos numéricos).";
                mensajeError.style.display = 'block';
            } else {
 const mensajeRegistroExitoso = `Registro exitoso, bienvenido ${nombreUsuario}`;
                alert(mensajeRegistroExitoso);

                // Volvemos  a index.php
                window.location.href = 'index.php';

                // Esto es necesario para limpiar los campos si regresamos a la página
                document.getElementById('username').value = '';
                document.getElementById('email').value = '';
                document.getElementById('password').value = '';
                document.getElementById('birthdate').value = '';
                document.getElementById('phone').value = '';
                mensajeError.style.display = 'none';
            }
        }
    }
</script>
<!-- Incluye el archivo JavaScript de Bootstrap 5 al final del body para mejorar el rendimiento -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
<footer class="bg-dark text-light text-center py-3">
    <div class="container">
        <p class="mb-0">¡Bienvenido a nuestra tienda de libros en línea! Encuentra una amplia selección de libros de diversos géneros, autores destacados y categorías interesantes. Explora, descubre y sumérgete en el maravilloso mundo de la lectura. ¡Nunca ha sido tan fácil comprar tus libros favoritos!</p>
    </div>
</footer>
</html>