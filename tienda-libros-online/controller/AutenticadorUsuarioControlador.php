<?php 

# Inicializamos las variables $adminLink y $loginLink como cadenas vacías
$adminLink = '';
$userLink = '';
$loginLink = '<li class="nav-item">
                <a class="nav-link" href="views/RegistroUsuarioFormulario.php">Registro</a>
            </li>';
$loginLink .= '<li class="nav-item">
                <a class="nav-link" href="views/Login.php">Login</a>
            </li>';

if (isset($_SESSION['user_id'])) {
    include "models/ValidarSesion.php";

    if (esAdmin($_SESSION['user_id'], $conn)) {
        // El usuario logueado es un administrador
        $adminLink = '<li class="nav-item">
                        <a class="nav-link" href="views/MenuAdministrador.php">Admin</a>
                    </li>';
        $loginLink = '<li class="nav-item">
                        <a class="nav-link" href="controller/LogoutControlador.php">Cerrar Sesión</a>
                    </li>';
    } else {
        // El usuario logueado no es administrador; es un usuario registrado a través de RegistroUsuarioFormulario-usuario.php
        $userName = obtenerNombreDeUsuario($_SESSION['user_id'], $conn);
        $userLink = "<li class='nav-item'>
                        <a class='nav-link'>$userName</a>
                    </li>";
        $loginLink = '<li class="nav-item">
                        <a class="nav-link" href="controller/LogoutControlador.php">Cerrar Sesión</a>
                    </li>';
    }
}


?>