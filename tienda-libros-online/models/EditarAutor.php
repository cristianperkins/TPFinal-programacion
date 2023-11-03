<?php
class AutorEditor {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateAuthor($nombre, $apellido, $id) {
        $nombre = htmlspecialchars($nombre); // Evitamos problemas de seguridad
        $apellido = htmlspecialchars($apellido); // Evitamos problemas de seguridad

        if (empty($nombre) && empty($apellido)) {
            return "Son necesarios los datos del autor";
        } elseif (empty($nombre)) {
            return "El nombre del autor es necesario";
        } else {
            $sql = "UPDATE autor SET nombre = ?, apellido = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$nombre, $apellido, $id]);
            if ($result) {
                return "¡Actualización exitosa!";
            } else {
                return "¡Error desconocido!";
            }
        }
    }
}
?>