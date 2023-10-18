<?php
session_start();

# Incluye tu archivo de configuración de base de datos (db_conexion.php)
include "db_conexion.php";

// Establecer una variable para errores
$errors = [];

// Conectarse a la base de datos
try {
    $conn = new PDO("mysql:host=localhost;dbname=tienda_libros_online_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}

// Obtener información del libro basada en un ID proporcionado
$bookId = isset($_GET['book_id']) ? $_GET['book_id'] : null;
if (!$bookId) {
    // Redirige a alguna página de error o maneja la falta de un ID de libro
    header("Location: error.php");
    exit;
}

$query = "SELECT libros.titulo, libros.descripcion, libros.precio, libros.fecha_publicacion, libros.portada, autor.nombre AS autor_nombre, autor.apellido AS autor_apellido, categorias.nombre AS categoria_nombre
          FROM libros
          INNER JOIN autor ON libros.autor_id = autor.id
          INNER JOIN categorias ON libros.categoria_id = categorias.id
          WHERE libros.id = :book_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
$stmt->execute();
$libro_comprado = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['precio'] = $libro_comprado['precio']; // Establece el precio en la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesa el formulario de compra aquí
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $email_confirmation = $_POST['email_confirmation'];

  // Validación de campos para mensajes de error
if (empty($nombre)) {
    $errors['nombre'] = "El nombre es requerido.";
} elseif (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
    $errors['nombre'] = "El nombre no debe contener símbolos o números. Solo se permiten letras y espacios.";
}

if (empty($apellido)) {
    $errors['apellido'] = "El apellido es requerido.";
} elseif (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $apellido)) {
    $errors['apellido'] = "El apellido no debe contener símbolos o números. Solo se permiten letras y espacios.";
}

if (empty($direccion)) {
    $errors['direccion'] = "La dirección es requerida.";
} elseif (preg_match('/^\d/', $direccion)) {
    $errors['direccion'] = "La dirección no puede comenzar con números.";
}

    if (empty($ciudad)) {
        $errors['ciudad'] = "La ciudad es requerida.";
    } elseif (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $ciudad)) {
        $errors['ciudad'] = "La ciudad no debe contener símbolos o números.";
    }

    if (empty($codigo_postal)) {
        $errors['codigo_postal'] = "El código postal es requerido.";
    } elseif (!is_numeric($codigo_postal) || strlen($codigo_postal) !== 4) {
        $errors['codigo_postal'] = "El código postal debe contener 4 números.";
    }

    if (empty($telefono)) {
        $errors['telefono'] = "El teléfono es requerido.";
    } elseif (!is_numeric($telefono) || strlen($telefono) < 10) {
        $errors['telefono'] = "El teléfono debe contener al menos 10 números.";
    }

    if (empty($email)) {
        $errors['email'] = "El E-mail es requerido.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "El E-mail es inválido, ingresa uno válido.";
    }

    if (empty($email_confirmation)) {
        $errors['email_confirmation'] = "La confirmación del E-mail es requerida.";
    } elseif ($email !== $email_confirmation) {
        $errors['email_confirmation'] = "La confirmación del E-mail no coincide con el E-mail ingresado.";
    }

    if (empty($errors)) {
        // Mostrar mensaje de compra exitosa
        echo '<script>';
        echo 'alert("Gracias por comprar el libro ' . $libro_comprado['titulo'] . '. Esté atento a su correo electrónico para el seguimiento de la compra. Gracias por confiar en nuestro servicio.");';
        echo 'window.location.href = "index.php";'; // Redirige al indice
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Libro</title>
    <!-- Enlace al archivoCSS de Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<!-- Enlace al archivo CSS personalizado -->
<link href="css/estilos-compra.css" rel="stylesheet">

</head>
<body>
    <!-- Barra de navegación -->
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
    <div class="container mt-4">
    <h1>Compra de Libro</h1>

    <div class="text-center book-info">
        <!-- Obtenemos la imagen del libro -->
        <img src="archivos/cover/<?= $libro_comprado['portada'] ?>" alt="Portada" style="max-height: 150px">

        <!-- Mostramos la información del libro -->
        <h2><?= $libro_comprado['titulo'] ?></h2>
        <p>Autor: <?= $libro_comprado['autor_nombre'] . ' ' . $libro_comprado['autor_apellido'] ?></p>
        <p>Categoría: <?= $libro_comprado['categoria_nombre'] ?></p>
        <p>Descripción: <?= $libro_comprado['descripcion'] ?></p>
        <p>Precio: $<?= number_format($_SESSION['precio'], 2) ?> pesos argentinos</p>
        <p>Año de Publicación: <?= $libro_comprado['fecha_publicacion'] ?></p>
    </div>

    <h2>Datos de Compra</h2>
    <!-- Formulario de compra -->
    <form method="post">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
            <?php if (isset($errors['nombre'])) { ?>
                <div class="text-danger"><?= $errors['nombre'] ?></div>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
            <?php if (isset($errors['apellido'])) { ?>
                <div class="text-danger"><?= $errors['apellido'] ?></div>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
            <?php if (isset($errors['direccion'])) { ?>
                <div class="text-danger"><?= $errors['direccion'] ?></div>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" required>
            <?php if (isset($errors['ciudad'])) { ?>
                <div class="text-danger"><?= $errors['ciudad'] ?></div>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required pattern="[0-9]{4}">
            <?php if (isset($errors['codigo_postal'])) { ?>
                <div class="text-danger"><?= $errors['codigo_postal'] ?></div>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" required pattern="[0-9]{10,}">
            <?php if (isset($errors['telefono'])) { ?>
                <div class="text-danger"><?= $errors['telefono'] ?></div>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email"       required>
                <?php if (isset($errors['email'])) { ?>
                    <div class="text-danger"><?= $errors['email'] ?></div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="email_confirmation">Confirmación de E-mail:</label>
                <input type="email" class="form-control" id="email_confirmation" name="email_confirmation" required>
                <?php if (isset($errors['email_confirmation'])) { ?>
                    <div class="text-danger"><?= $errors['email_confirmation'] ?></div>
                <?php } ?>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Comprar</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
            </div>
        </form>
    </div>

    <!-- Incluye el archivo JavaScript de Bootstrap 5 al final del body para mejorar el rendimiento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>