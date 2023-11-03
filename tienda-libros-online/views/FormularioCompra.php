<?php
session_start();

# Incluye el archivo de configuración de base de datos (db_conexion.php)
include "../config/db_conexion.php";

// Incluimos el archivo para validar sesion del usuario
include "../models/ValidarSesion.php";

include "../controller/CompraControlador.php";
include "../models/Compra.php";


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Libro</title>
    <!-- Enlace al archivo CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Enlace al archivo CSS personalizado -->
    <link href="../css/estilos-compra.css" rel="stylesheet">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Libros Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Contacto.php">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="SobreNosotros.php">Sobre Nosotros</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link"><?php echo obtenerNombreDeUsuario($_SESSION['user_id'], $conn); ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Compra de Libro</h1>

        <div class="text-center book-info">
            <!-- Obtenemos la imagen del libro -->
            <img src="../archivos/cover/<?= $libro_comprado['portada'] ?>" alt="Portada" style="max-height: 150px">

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
                <input type="email" class="form-control" id="email" name="email" required>
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