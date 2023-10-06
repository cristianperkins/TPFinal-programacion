<?php
class Libro {
    public $id;
    public $titulo;
    public $autor_id;
    public $descripcion;
    public $categoria_id;
    public $portada; // Propiedad necesaría para la imagen, abajo explico el porque
}

/**
 * Acá obtenemos todos los libros de la base de datos como objetos Libro.
 */
function get_all_books($con) {
    // Consulta SQL para obtener todos los libros ordenados por ID en orden descendente.
    $sql = "SELECT * FROM libros ORDER BY id DESC";

    // Preparar y ejecutar la consulta.
    $stmt = $con->prepare($sql);
    $stmt->execute();

    $libros = array();

    // Creamos el objeto libro y almacenamos todo en el array libros.
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $libro = new Libro();
        $libro->id = $row['id'];
        $libro->titulo = $row['titulo'];
        $libro->autor_id = $row['autor_id'];
        $libro->descripcion = $row['descripcion'];
        $libro->categoria_id = $row['categoria_id'];
        $libro->portada = $row['portada']; // Sin esto no aparecería nunca la imagen por más que la ruta y datos en la db esten bien
        $libros[] = $libro;
    }

    //Retornamos los valores
    return $libros;
}
?>