<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo_libro = $_POST['book_title'];
    $descripcion_libro = $_POST['book_description'];
    $id_autor = $_POST['book_author'];
    $id_categoria = $_POST['book_category'];
    $precio_libro = $_POST['book_price'];
    $anio_publicacion = $_POST['book_year'];

    $stmt = null; // Inicializa $stmt como nulo (sin esto el programa muere)

    if (isset($_POST['keep_cover']) && $_POST['keep_cover'] === "on") {
        // No actualizar la portada
        $sql = "UPDATE libros SET titulo = ?, autor_id = ?, descripcion = ?, categoria_id = ?, precio = ?, fecha_publicacion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $titulo_libro, PDO::PARAM_STR);
        $stmt->bindParam(2, $id_autor, PDO::PARAM_INT);
        $stmt->bindParam(3, $descripcion_libro, PDO::PARAM_STR);
        $stmt->bindParam(4, $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(5, $precio_libro, PDO::PARAM_STR);
        $stmt->bindParam(6, $anio_publicacion, PDO::PARAM_INT);
        $stmt->bindParam(7, $id, PDO::PARAM_INT);
    } else {
        // Actualizar la portada
        $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');
        $resultado_subida = subir_archivo($_FILES['book_cover'], 'archivos/cover');
        if ($resultado_subida['estado'] === 'éxito') {
            $nombre_portada = $resultado_subida['archivo'];

            $sql = "UPDATE libros SET titulo = ?, autor_id = ?, descripcion = ?, categoria_id = ?, portada = ?, precio = ?, fecha_publicacion = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $titulo_libro, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_autor, PDO::PARAM_INT);
            $stmt->bindParam(3, $descripcion_libro, PDO::PARAM_STR);
            $stmt->bindParam(4, $id_categoria, PDO::PARAM_INT);
            $stmt->bindParam(5, $nombre_portada, PDO::PARAM_STR);
            $stmt->bindParam(6, $precio_libro, PDO::PARAM_STR);
            $stmt->bindParam(7, $anio_publicacion, PDO::PARAM_INT);
            $stmt->bindParam(8, $id, PDO::PARAM_INT);
        }
    }

    if ($stmt !== null && $stmt->execute()) {
        $mensaje_exito = "Libro actualizado con éxito";
    } elseif ($stmt === null) {
        $mensaje_error = "No se realizaron modificaciones";
    } else {
        $mensaje_error = "Error al actualizar el libro";
    }
}

?>