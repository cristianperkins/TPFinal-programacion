<?php
class EliminarAutor {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteAuthor($authorId) {
        $sql = "DELETE FROM autor WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $resultado = $stmt->execute([$authorId]);
        return $resultado;
    }
}