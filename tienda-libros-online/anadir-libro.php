<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

include "db_conexion.php";
include "php/func-categoria.php";
include "php/func-autor.php";
include "php/func-subir-archivo.php";

$categorias = get_all_categories($conn);
$autores = get_all_authors($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo_libro = $_POST['book_title'];
    $descripcion_libro = $_POST['book_description'];
    $id_autor = $_POST['book_author'];
    $id_categoria = $_POST['book_category'];
    $precio_libro = $_POST['book_price']; // Nuevo campo de precio
    $anio_publicacion = $_POST['book_year']; // Nuevo campo de fecha de publicación

    $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    $resultado_subida = subir_archivo($_FILES['book_cover'], 'archivos/cover');

    if ($resultado_subida['estado'] === 'éxito') {
        $nombre_portada = $resultado_subida['archivo'];

        // Añade la fecha de publicación al formato MySQL (AAAA-MM-DD)
        $fecha_publicacion = date('Y-m-d', strtotime($anio_publicacion . '-01-01'));

        $sql = "INSERT INTO libros (titulo, autor_id, descripcion, categoria_id, portada, precio, fecha_publicacion) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $titulo_libro, PDO::PARAM_STR);
        $stmt->bindParam(2, $id_autor, PDO::PARAM_INT);
        $stmt->bindParam(3, $descripcion_libro, PDO::PARAM_STR);
        $stmt->bindParam(4, $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(5, $nombre_portada, PDO::PARAM_STR);
        $stmt->bindParam(6, $precio_libro, PDO::PARAM_STR);
        $stmt->bindParam(7, $fecha_publicacion, PDO::PARAM_STR); // Vincula la fecha de publicación

        if ($stmt->execute()) {
            $mensaje_exito = "Libro añadido con éxito";
        } else {
            $mensaje_error = "Error al agregar el libro";
        }
    } else {
        $mensaje_error = $resultado_subida['mensaje'];
    }
}
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
    <link href="css/estilos-admin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Barra de navegación del admin -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="anadir-libro.php">Añadir Libro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="anadir-categoria.php">Añadir Categoría</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="anadir-autor.php">Añadir Autor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
        <form action="anadir-libro.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
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