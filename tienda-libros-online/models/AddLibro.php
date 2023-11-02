<?php 

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