<?php
class Libro {
    public $id;
    public $titulo;
    public $autor_id;
    public $descripcion;
    public $categoria_id;
    public $portada;
    public $precio;
    public $fecha_publicacion;

    public function get_all_books($con, $order = 'ASC') {
        $sql = "SELECT * FROM libros ORDER BY id $order";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $libros = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $libro = new Libro();
            $libro->id = $row['id'];
            $libro->titulo = $row['titulo'];
            $libro->autor_id = $row['autor_id'];
            $libro->descripcion = $row['descripcion'];
            $libro->categoria_id = $row['categoria_id'];
            $libro->portada = $row['portada'];
            $libro->precio = $row['precio'];
            $libro->fecha_publicacion = $row['fecha_publicacion'];
            $libros[] = $libro;
        }

        return $libros;
    }

    public function get_book($con, $id) {
        $sql = "SELECT * FROM libros WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function anadir_libro($titulo, $autor_id, $descripcion, $categoria_id, $portada) {
        global $conn;

        $sql = "INSERT INTO libros (titulo, autor_id, descripcion, categoria_id, portada) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $titulo, PDO::PARAM_STR);
        $stmt->bindParam(2, $autor_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(4, $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(5, $portada, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
?>