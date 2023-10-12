<?php
session_start();

class CategoriaEditor {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateCategory($name, $id) {
        $name = htmlspecialchars($name); // Evita problemas de seguridad
        if (empty($name)) {
            $error_msg = "El nombre de la categoría es obligatorio";
            $this->redirectWithError($error_msg, $id);
        } else {
            $sql = "UPDATE categorias SET nombre = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$name, $id]);
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
        header("Location: ../editar-categoria.php?error=" . urlencode($error_msg) . "&id=" . $id);
        exit;
    }

    private function redirectWithSuccess($success_msg, $id) {
        header("Location: ../editar-categoria.php?success=" . urlencode($success_msg) . "&id=" . $id);
        exit;
    }
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    include "../db_conexion.php";
    
    if (isset($_POST['nombre_categoria']) && isset($_POST['categoria_id'])) {
        $editor = new CategoriaEditor($conn);
        $editor->updateCategory($_POST['nombre_categoria'], $_POST['categoria_id']);
    } else {
        header("Location: ../admin.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>