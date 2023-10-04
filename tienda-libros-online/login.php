<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Enlace al archivo CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <div class="d-flex justify-content-center 
    align-items-center min-vh-100">
        <form class="p-5 rounded shadow-lg" 
            style="max-width: 30rem; width: 100%" 
            method="POST" 
            action="php/autentificacion.php">

            <h1 class="text-center display-4 pb-5">Login</h1>
            <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div> 
            <?php } ?>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Dirección de E-mail</label>
                <input type="email" 
                 class="form-control"
                 name="email"
                 id="exampleInputEmail1" 
                 aria-describedby="emailHelp">
                <div id="emailHelp" 
                 class="form-text">No compartiremos tus datos con nadie..</div>
            </div>
            
            <div class="mb-3">
                <label for="exampleInputPassword1" 
                 class="form-label">Contraseña</label>
                <input type="password" 
                 class="form-control"
                 name="password"
                 id="exampleInputPassword1">
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
            <a href="index.php" 
             class="btn btn-link">
             Store</a>
        </form>
    </div>

    <!-- Incluye el archivo JavaScript de Bootstrap 5 al final del body para mejorar el rendimiento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>