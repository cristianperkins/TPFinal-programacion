<?php 

// Conectarse a la base de datos
try {
    $conn = new PDO("mysql:host=localhost;dbname=tienda_libros_online_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}

// Obtener información del libro basada en un ID proporcionado
$bookId = isset($_GET['book_id']) ? $_GET['book_id'] : null;
if (!$bookId) {
    // Redirige a alguna página de error o maneja la falta de un ID de libro
    header("Location: error.php");
    exit;
}


?>