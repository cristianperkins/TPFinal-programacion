<?php
class CategoriaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateCategory($name, $id) {
        $name = htmlspecialchars($name);
        if (empty($name)) {
            return "El nombre de la categoría es obligatorio";
        } else {
            $sql = "UPDATE categorias SET nombre = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$name, $id]);
            if ($result) {
                return "¡Actualización exitosa!";
            } else {
                return "¡Error desconocido!";
            }
        }
    }
}
?>