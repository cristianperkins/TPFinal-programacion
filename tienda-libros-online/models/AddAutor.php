<?php
include '../config/db_conexion.php';

class AuthorManager {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function agregarAutor($nombre_autor, $apellido_autor) {
        $mensaje = "";

        if (empty($nombre_autor) && empty($apellido_autor)) {
            $mensaje = "El nombre y el apellido del autor son necesarios";
        } elseif (empty($nombre_autor)) {
            $mensaje = "El nombre es necesario";
        } else {
            $sql  = "INSERT INTO autor (nombre, apellido) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $resultado  = $stmt->execute([$nombre_autor, $apellido_autor]);

            if ($resultado) {
                $mensaje = "Autor añadido con éxito";
            } else {
                $mensaje = "Error al agregar autor";
            }
        }

        return $mensaje;
    }
}
?>