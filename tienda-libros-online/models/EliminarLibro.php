<?php
class EliminarLibro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function eliminarLibro($libroId) {
        $sql = "DELETE FROM libros WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $resultado = $stmt->execute([$libroId]);
        return $resultado;
    }
}