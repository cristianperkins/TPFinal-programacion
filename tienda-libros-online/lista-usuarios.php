<?php
session_start();

// Verificamos la autenticación del usuario
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

# Conexión con la base de datos
include "db_conexion.php";

// Variable para almacenar el mensaje de éxito si existe
$successMessage = "";

// Verifica si se proporcionó un mensaje de éxito
if (isset($_GET['success']) && !empty($_GET['success'])) {
    $successMessage = $_GET['success'];
}

# Realiza la consulta para obtener la lista de usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

$usuarios = [];
if ($result) {
    $usuarios = $result->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <!-- Enlace al archivo CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Enlace al DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.10/css/jquery.dataTables.css">
    <!-- Enlace al archivo CSS personalizado -->
    <link href="css/estilos-admin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Barra de navegación para la lista de usuarios -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Tienda</a>
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
                        <li class "nav-item">
                            <a class="nav-link disabled" href="lista-usuarios.php">Lista de Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Muestra el mensaje de éxito si existe -->
        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php } ?>

        <!-- Tabla para mostrar los usuarios -->
        <h4>Lista de Usuarios</h4>
        <table id="usuarios-table" class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Correo Electrónico</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre_usuario']; ?></td>
                    <td><?php echo $usuario['correo_electronico']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($usuario['fecha_nacimiento'])); ?></td>
                    <td><?php echo $usuario['telefono']; ?></td>
                    <td>
                        <!-- Agrega enlaces para eliminar usuarios -->
                        <a href="php/func-eliminar-usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            </table>

<!-- Incluye el archivo JavaScript de Bootstrap al final del body para mejorar el rendimiento si es necesario -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</div>
</body>
</html>