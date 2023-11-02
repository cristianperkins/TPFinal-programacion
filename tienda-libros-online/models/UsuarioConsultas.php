<?php 

class Usuarios {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario($nombreUsuario, $correoElectronico, $contrasena, $fechaNacimiento, $telefono) {
        try {
            $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena, fecha_nacimiento, telefono) VALUES (:nombreUsuario, :correoElectronico, :contrasena, :fechaNacimiento, :telefono)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nombreUsuario', $nombreUsuario);
            $stmt->bindParam(':correoElectronico', $correoElectronico);
            $stmt->bindParam(':contrasena', $contrasenaHash);
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Error al registrar usuario: " . $e->getMessage();
        }
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