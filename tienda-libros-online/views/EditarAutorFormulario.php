<?php
include "../models/Autor.php";
session_start();

# Si el administrador está autenticado
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    
    # Si el ID del autor no está definido o no es un número válido
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        # Redirigir a la página admin.php
        header("Location: MenuAdministrador.php");
        exit;
    }

    $id = $_GET['id'];

    # Archivo de Conexión a la Base de Datos
    include "../db_conexion.php";

  
    $autorModel = new Autor($conn);

    # Obtiene el objeto del autor por ID
    $autor = $autorModel->getAuthorById($id);

    # Si el autor no se encontró
    if ($autor === null) {
        # Redirigir a la página admin.php
        header("Location: MenuAdministrador.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
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
                            <a class="nav-link" href="../anadir-libro.php">Añadir Libro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="AnadirCategoria.php">Añadir Categoría</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="AnadirAutor.php">Añadir Autor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <form action="../controller/EditarAutorControlador.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;">
            <h1 class="text-center pb-5 display-4 fs-3">
                Editar Autor
            </h1>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Nombre del autor</label>
                <input type="text" class="form-control" name="nombre_autor" value="<?= htmlspecialchars($autor->nombre) ?>">
                <input type="hidden" name="autor_id" value="<?= $id ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido del autor</label>
                <input type="text" class="form-control" name="apellido_autor" value="<?= htmlspecialchars($autor->apellido) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Autor</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </form>
    </div>
</body>
</html>