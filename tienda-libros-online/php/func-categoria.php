<?php
// Creamos la clase Categoria
class Categoria {
    public $id;
    public $nombre;

    // Constructor de la clase Categoria
    public function __construct($id, $nombre) {
        $this->id = $id; // Asigna el ID proporcionado al objeto
        $this->nombre = $nombre; // Asigna el nombre proporcionado al objeto
    }
}

// Función para obtener todas las categorías de la base de datos
function get_all_categories($con) {
    $sql  = "SELECT * FROM categorias"; // Consulta SQL para seleccionar todas las categorías
    $stmt = $con->prepare($sql); // Preparamos la consulta
    $stmt->execute(); // Ejecutamos la consulta

    $categorias = array(); // Creamos un arreglo vacío para almacenar objetos de categoría

    if ($stmt->rowCount() > 0) {
        // Si se encontraron resultados en la consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea un nuevo objeto Categoria con los datos del resultado
            $categoria = new Categoria($row['id'], $row['nombre']);
            $categorias[] = $categoria; // Agrega el objeto Categoria al arreglo de categorías
        }
    }

    return $categorias; // Devolvemos el arreglo de objetos de categoría
}

// Función para obtener una categoría por su ID
function get_category($con, $id) {
    $sql  = "SELECT * FROM categorias WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Crea un nuevo objeto Categoria con los datos del resultado
        $categoria = new Categoria($row['id'], $row['nombre']);
        return $categoria;
    } else {
        return null; // No se encontró una categoría con el ID especificado
    }
}
?>