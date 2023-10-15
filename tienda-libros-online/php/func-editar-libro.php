<?php
session_start();
include "../db_conexion.php";

class GestorLibro {
    private $conn;

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function estaAutenticado() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
    }

    public function redirigirALogin() {
        header("Location: ../login.php");
        exit;
    }

    // Función para editar un libro
    public function editarLibro($id, $titulo, $autor_id, $descripcion, $categoria_id, $portada) {
        // Armamos la consulta  para actualizar un libro
        $sql = "UPDATE libros SET titulo = ?, autor_id = ?, descripcion = ?, categoria_id = ?, portada = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        // Mandamos la consulta con los nuevos datos
        $resultado = $stmt->execute([$titulo, $autor_id, $descripcion, $categoria_id, $portada, $id]);

        if ($resultado) {
            // Si todo salió joya, redirigimos con un mensaje copado
            header("Location: ../editar-libro.php?success=Libro actualizado con éxito");
        } else {
            // Si hubo problemas al actualizar el libro, mandamos un mensaje de error
            header("Location: ../editar-libro.php?error=Error al actualizar el libro");
        }
        exit;
    }

    public function redirigiraAdmin() {
        // Nos mandamos a la página de administración directamente
        header("Location: ../admin.php");
        exit;
    }
}

$gestorLibro = new GestorLibro($conn);

if (!$gestorLibro->estaAutenticado()) {
    // Si no está logueado, le mandamos a hacer el login
    $gestorLibro->redirigirALogin();
}

if (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['autor_id']) && isset($_POST['descripcion']) && isset($_POST['categoria_id']) && isset($_POST['portada'])) {
    // Si le mandaron data para editar, la agarramos al toque
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor_id = $_POST['autor_id'];
    $descripcion = $_POST['descripcion'];
    $categoria_id = $_POST['categoria_id'];
    $portada = $_POST['portada'];

    // Llamamos a la función para editar el libro con estos datos 
    $gestorLibro->editarLibro($id, $titulo, $autor_id, $descripcion, $categoria_id, $portada);
} else {
    // Si no nos mandaron data, volvemos a la administración
    $gestorLibro->redirigiraAdmin();
}
?>