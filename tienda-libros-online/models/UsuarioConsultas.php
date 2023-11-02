<?php 

class Usuarios {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarUsuario($usuario_id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$usuario_id]);
    }

}

?>