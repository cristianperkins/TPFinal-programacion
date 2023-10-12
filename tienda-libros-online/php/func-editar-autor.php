<?php
session_start();

class AutorEditor {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateAuthor($nombre, $apellido, $id) {
        $nombre = htmlspecialchars($nombre); // Evitamos problemas de seguridad
        $apellido = htmlspecialchars($apellido); // Evitamos problemas de seguridad
        if (empty($nombre)) {
            $error_msg = "El nombre del autor es obligatorio";
            $this->redirectWithError($error_msg, $id);
        } else {
            $sql = "UPDATE autor SET nombre = ?, apellido = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$nombre, $apellido, $id]);
            if ($result) {
                $success_msg = "¡Actualización exitosa!";
                $this->redirectWithSuccess($success_msg, $id);
            } else {
                $error_msg = "¡Error desconocido!";
                $this->redirectWithError($error_msg, $id);
            }
        }
    }

    private function redirectWithError($error_msg, $id) {
        header("Location: ../editar-autor.php?error=" . urlencode($error_msg) . "&id=" . $id);
        exit;
    }

    private function redirectWithSuccess($success_msg, $id) {
        header("Location: ../editar-autor.php?success=" . urlencode($success_msg) . "&id=" . $id);
        exit;
    }
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    include "../db_conexion.php";
    
    if (isset($_POST['nombre_autor']) && isset($_POST['apellido_autor']) && isset($_POST['autor_id'])) {
        $editor = new AutorEditor($conn);
        $editor->updateAuthor($_POST['nombre_autor'], $_POST['apellido_autor'], $_POST['autor_id']);
    } else {
        header("Location: ../admin.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}