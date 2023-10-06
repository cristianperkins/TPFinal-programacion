<?php

// Definición de la clase Categoria para representar objetos de categoría

class Categoria {
    public $id;    
    public $nombre; 

    // Constructor de la clase Categoria

    public function __construct($id, $nombre) {
        $this->id = $id;         
        $this->nombre = $nombre; 
    }
}

// Función para obtener todas las categorías de la base de datos

function get_all_categories($con){
    $sql = "SELECT * FROM categorias";  
    $stmt = $con->prepare($sql);        
    $stmt->execute();                   

    $categorias = array();  // Iniciamos un arreglo vacío para almacenar objetos de categoría

    if ($stmt->rowCount() > 0) {
        // Si se encontraron resultados en la consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea un nuevo objeto Categoria con los datos del resultado
            $categoria = new Categoria($row['id'], $row['nombre']);
            $categorias[] = $categoria; // Agrega el objeto Categoria al arreglo de categorías
        }
    } else {
        $categorias = 0; // Si no se encontraron categorías, se asigna 0
    }
    return $categorias; // Devuelve el arreglo de objetos de categoría
}

?>