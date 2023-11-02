<?php
class EliminarCategoria {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function eliminarCategoria($categoriaId) {
        $sql = "DELETE FROM categorias WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $resultado = $stmt->execute([$categoriaId]);
        return $resultado;
    }
}