<?php
class Autor {
    private $conn;

    public $id;
    public $nombre;
    public $apellido;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAuthors() {
        $sql = "SELECT * FROM autor";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $autores = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $autor = new Autor($this->conn);
            $autor->id = $row['id'];
            $autor->nombre = $row['nombre'];
            $autor->apellido = $row['apellido'];
            $autores[] = $autor;
        }

        return $autores;
    }

    public function getAuthorById($id) {
        $sql = "SELECT * FROM autor WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $autor = new Autor($this->conn);
            $autor->id = $row['id'];
            $autor->nombre = $row['nombre'];
            $autor->apellido = $row['apellido'];
            return $autor;
        } else {
            return null;
        }
    }
}
?>