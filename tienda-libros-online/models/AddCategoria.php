<?php
class CategoriaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function agregarCategoria($nombre_categoria) {
        if (empty($nombre_categoria)) {
            return "El nombre de la categoría es requerido";
        } else {
            $sql  = "INSERT INTO categorias (nombre) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $resultado = $stmt->execute([$nombre_categoria]);

            if ($resultado) {
                return "Categoría añadida con éxito";
            } else {
                return "Error al agregar categoría";
            }
        }
    }
}
?>