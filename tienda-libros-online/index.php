<?php
session_start();

# Database Connection File
include "db_conexion.php";

# Recuperar todas las categorías y autores de la base de datos
$queryCategories = "SELECT * FROM categorias";
$stmtCategories = $conn->query($queryCategories);
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

$queryAuthors = "SELECT * FROM autor";
$stmtAuthors = $conn->query($queryAuthors);
$authors = $stmtAuthors->fetchAll(PDO::FETCH_ASSOC);

# Variables para filtrar libros
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;
$selectedAuthor = isset($_GET['author']) ? $_GET['author'] : null;

# Podemos realizar una búsqueda si se ha proporcionado una palabra clave
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT libros.id, libros.titulo, libros.descripcion, libros.portada, autor.nombre AS autor_nombre, autor.apellido AS autor_apellido, categorias.nombre AS categoria, libros.precio, libros.fecha_publicacion
              FROM libros
              INNER JOIN autor ON libros.autor_id = autor.id
              INNER JOIN categorias ON libros.categoria_id = categorias.id
              WHERE libros.titulo LIKE :search
              OR autor.nombre LIKE :search
              OR autor.apellido LIKE :search
              OR categorias.nombre LIKE :search";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    # Si no se proporciona una palabra clave, mostrar todos los libros o aplicar filtros
    $query = "SELECT libros.id, libros.titulo, libros.descripcion, libros.portada, autor.nombre AS autor_nombre, autor.apellido AS autor_apellido, categorias.nombre AS categoria, libros.precio, libros.fecha_publicacion
              FROM libros
              INNER JOIN autor ON libros.autor_id = autor.id
              INNER JOIN categorias ON libros.categoria_id = categorias.id";

    if ($selectedCategory) {
        $query .= " WHERE libros.categoria_id = :category";
    } elseif ($selectedAuthor) {
        $query .= " WHERE libros.autor_id = :author";
    }

    $stmt = $conn->prepare($query);

    if ($selectedCategory) {
        $stmt->bindParam(':category', $selectedCategory, PDO::PARAM_INT);
    } elseif ($selectedAuthor) {
        $stmt->bindParam(':author', $selectedAuthor, PDO::PARAM_INT);
    }

    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

# Verificamos si el usuario admin está autenticado
$adminLink = '';
$loginLink = '<li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>';

if (isset($_SESSION['user_id']) && $_SESSION['user_email'] === 'email_del_admin@example.com') {
    $adminLink = '<li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>';
    $loginLink = '<li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
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
                    <?= $adminLink ?>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre-nosotros.php">Sobre Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">Registro</a>
                    </li>
                    <?= $loginLink ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="container my-3">
    <form action="index.php" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar libros por título, autor o categoría" aria-label="Buscar" aria-describedby="basic-addon">
            <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Buscar</button>
        </div>
    </form>
</div>

 

        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <?php foreach ($books as $book) { ?>
                        <div class="col-md-4 mb-4">
                        <div class="card box-shadow">
                                <img class="card-img-top" src="archivos/cover/<?= $book['portada'] ?>" alt="Portada" style="max-height: 150px">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $book['titulo'] ?></h5>
                                    <p class="card-text">
                                        <strong>Autor:</strong> <?= $book['autor_nombre'] . ' ' . $book['autor_apellido'] ?><br>
                                        <strong>Categoría:</strong> <?= $book['categoria'] ?><br>
                                        <strong>Precio:</strong> <?= '$' . $book['precio'] ?><br>
                                        <strong>Año de Publicación:</strong> <?= $book['fecha_publicacion'] ?><br>
                                        <strong>Descripción:</strong> <?= substr($book['descripcion'], 0, 75) . (strlen($book['descripcion']) > 100 ? "..." : "") ?>
                                    </p>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-warning">
                                            <a href="compra.php?book_id=<?= $book['id'] ?>" style="text-decoration: none; color: white;">Comprar</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <h4 style="background-color: #007BFF; color: white; padding: 5px;">Categoría</h4>
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php">Todos</a></li>
                    <?php foreach ($categories as $category) { ?>
                        <li class="list-group-item">
                            <a href="index.php?category=<?= $category['id'] ?>"><?= $category['nombre'] ?></a>
                        </li>
                    <?php } ?>
                </ul>

                <h4 class="mt-4" style="background-color: #007BFF; color: white; padding: 5px;">Autor</h4>
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php">Todos</a></li>
                    <?php foreach ($authors as $author) { ?>
                        <li class="list-group-item">
                            <a href="index.php?author=<?= $author['id'] ?>"><?= $author['nombre'] . ' ' . $author['apellido'] ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Incluye el archivo JavaScript de Bootstrap 5 al final del body para mejorar el rendimiento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
<footer class="bg-dark text-light text-center py-3">
    <div class="container">
        <p class="mb-0">¡Bienvenido a nuestra tienda de libros en línea! Encuentra una amplia selección de libros de diversos géneros, autores destacados y categorías interesantes. Explora, descubre y sumérgete en el maravilloso mundo de la lectura. ¡Nunca ha sido tan fácil comprar tus libros favoritos!</p>
    </div>
</footer>
</html>