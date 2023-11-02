<?php
# Nombre servidor
$sName = "localhost";

# Nombre de usuario
$uName = "root";

# Contraseña
$pass = "";

# Nombre de la base de datos
$db_name = "tienda_libros_online_db";

try {
    // Crea una instancia de PDO con la conexión a la base de datos y selecciona la base de datos
    $conn = new PDO("mysql:host=$sName;dbname=$db_name;charset=utf8", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Conexión fallida : " . $e->getMessage();
}
?>