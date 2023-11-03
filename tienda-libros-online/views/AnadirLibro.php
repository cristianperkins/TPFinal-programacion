<?php

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: Login.php");
    exit;
}

include "../config/db_conexion.php";
include "../models/AddCover.php";
include "../models/AddLibro.php";


# Incluye la clase del modelo
include "../models/Autor.php";
$autorModel = new Autor($conn);
$autores = $autorModel->getAuthors();

# Incluye la clase del modelo
include "../models/Categoria.php";
$categoriaModel = new Categoria($conn);
$categorias = $categoriaModel->getCategories();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Libro</title>
    <!-- Enlace al archivo CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Enlace al DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.10/css/jquery.dataTables.css">
    <!-- Enlace al archivo CSS personalizado -->
    <link href="../css/estilos-admin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Barra de navegación del admin -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="MenuAdministrador.php">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../index.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" disabled>Añadir Libro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="AnadirCategoria.php">Añadir Categoría</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="AnadirAutor.php">Añadir Autor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../controller/LogoutControlador.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
        <form action="AnadirLibro.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
            <h1 class="text-center pb-5 display-4 fs-3">Añadir Libro</h1>
            <?php if (isset($mensaje_error)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($mensaje_error); ?>
                </div>
            <?php } ?>
            <?php if (isset($mensaje_exito)) { ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($mensaje_exito); ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Título del libro</label>
                <input type="text" class="form-control" name="book_title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción del libro</label>
                <textarea class="form-control" name="book_description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Autor del libro</label>
                <select class="form-select" name="book_author" required>
                    <option value="" disabled selected>Seleccione un autor</option>
                    <?php foreach ($autores as $autor) { ?>
                        <option value="<?= $autor->id ?>"><?= htmlspecialchars($autor->nombre . ' ' . $autor->apellido) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoría del libro</label>
                <select class="form-select" name="book_category" required>
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?= $categoria->id ?>"><?= htmlspecialchars($categoria->nombre) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
    <label class="form-label">Año de Publicación</label>
    <input type="number" class="form-control" name="book_year" required min="0" max="<?= date('Y') ?>">
</div>
<div class="mb-3">
    <label class="form-label">Precio (Pesos Argentinos)</label>
    <div class="input-group">
        <span class="input-group-text">$</span>
        <input type="text" class="form-control" name="book_price" value="<?= isset($_POST['book_price']) ? htmlspecialchars($_POST['book_price']) : '' ?>" required>
    </div>
</div>
            <div class="mb-3">
                <label class="form-label">Selección de portada</label>
                <div class="input-group">
                    <input type="file" id="inputPortada" class="form-control" name="book_cover" style="display: none;" required>
                    <label for="inputPortada" class="custom-file-upload">
                        Cargar Portada
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Añadir Libro</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </form>
    </div>
     <!-- Incluye el archivo JavaScript de Bootstrap 5 al final del body para mejorar el rendimiento -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>