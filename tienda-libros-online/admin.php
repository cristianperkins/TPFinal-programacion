<?php
session_start();

// Verificamos la autenticación del usuario
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

# Conexión con la base de datos
include "db_conexion.php";

# Incluir la función de los libros
include "php/func-libro.php";
$libros = get_all_books($conn, 'ASC');

# Incluir la función de los autores
include "php/func-autor.php";
$autores = get_all_authors($conn);

# Incluir la función de las categorías
include "php/func-categoria.php";
$categorias = get_all_categories($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
                            <a class="nav-link" href="lista-usuarios.php">Lista de Usuarios</a> <!-- Creación de página para mostrar lista de usuarios  -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Tabla para mostrar los libros -->

        <h4>Agregar Libros</h4>
        <table id="libros-table" class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Portada</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Precio</th> <!-- Nueva columna de Precio -->
                    <th>Año de Publicación</th> <!-- Nueva columna de Año de Publicación -->
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($libros as $libro) { ?>
                <tr>
                    <td><?= $libro->id ?></td>
                    <td>
                        <img width="100" src="archivos/cover/<?= $libro->portada ?>">
                    </td>
                    <td><?= htmlspecialchars($libro->titulo) ?></td>
                    <td>
                        <?php
                        $autorNombre = " ";
                        foreach ($autores as $autor) {
                            if ($autor->id == $libro->autor_id) {
                                $autorNombre = htmlspecialchars($autor->nombre . ' ' . $autor->apellido);
                                break;
                            }
                        }
                        echo $autorNombre;
                        ?>
                    </td>
                    <td><?= htmlspecialchars($libro->descripcion) ?></td>
                    <td>
                        <?php
                        $categoriaNombre = " ";
                        foreach ($categorias as $categoria) {
                            if ($categoria->id == $libro->categoria_id) {
                                $categoriaNombre = htmlspecialchars($categoria->nombre);
                                break;
                            }
                        }
                        echo $categoriaNombre;
                        ?>
                    </td>
                    <td>$<?= number_format($libro->precio, 2) ?></td> <!-- Muestra el Precio -->
                    <td><?= $libro->fecha_publicacion ?></td> <!-- Muestra la Fecha de Publicación -->
                    <td>
                        <div class="btn-group">
                            <a href="editar-libro.php?id=<?= $libro->id ?>" class="btn btn-warning" style="margin-right: 5px;">Editar</a>
                            <form action="php/func-eliminar-libro.php" method="post">
                                <input type="hidden" name="libro_id" value="<?= $libro->id ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <!-- Tabla para mostrar las categorías -->

        <h4>Agregar Categorías</h4>
        <table id="categorias-table" class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria) { ?>
                    <tr>
                        <td><?= $categoria->id ?></td>
                        <td><?= htmlspecialchars($categoria->nombre) ?></td>
                        <td>
                            <a href="editar-categoria.php?id=<?= $categoria->id ?>" class="btn btn-warning">Editar</a>
                            <a href="php/func-eliminar-categoria.php?id=<?= $categoria->id ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Tabla para mostrar los autores -->

        <h4>Agregar Autores</h4>
        <table id="autores-table" class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del Autor</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autores as $autor) { ?>
                    <tr>
                        <td><?= $autor->id ?></td>
                        <td><?= htmlspecialchars($autor->nombre . ' ' . $autor->apellido) ?></td>
                        <td>
                            <a href="editar-autor.php?id=<?=$autor->id ?>" class="btn btn-warning">Editar</a>
                            <a href="php/func-eliminar-autor.php?id=<?= $autor->id ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Incluye el archivo JavaScript de Bootstrap 5 al final del body para mejorar el rendimiento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>