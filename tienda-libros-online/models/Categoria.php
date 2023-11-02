<?php
class Categoria {
    private $conn;

    public $id;
    public $nombre;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCategories() {
        $sql = "SELECT * FROM categorias";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $categorias = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoria = new Categoria($this->conn);
            $categoria->id = $row['id'];
            $categoria->nombre = $row['nombre'];
            $categorias[] = $categoria;
        }

        return $categorias;
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categorias WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $categoria = new Categoria($this->conn);
            $categoria->id = $row['id'];
            $categoria->nombre = $row['nombre'];
            return $categoria;
        } else {
            return null;
        }
    }
}

?>