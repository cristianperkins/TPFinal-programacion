<?php
//Creamos la clase Autor
class Autor {
    public $id;
    public $nombre;
    public $apellido; // Agregamos el atributo apellido

    // Constructor de la clase Autor
    public function __construct($id, $nombre, $apellido) {
        $this->id = $id; // Asigna el ID proporcionado al objeto
        $this->nombre = $nombre; // Asigna el nombre proporcionado al objeto
        $this->apellido = $apellido; // Asigna el apellido proporcionado al objeto
    }
}

// Función para obtener todos los autores de la base de datos
function get_all_author($con) {
    $sql  = "SELECT * FROM autor"; // Consulta SQL para seleccionar todos los autores
    $stmt = $con->prepare($sql); // Preparamos la consulta
    $stmt->execute(); // Ejecutamos la consulta

    $autores = array(); // Creamos un arreglo vacío para almacenar objetos de autor

    if ($stmt->rowCount() > 0) {
        // Si se encontraron resultados en la consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crea un nuevo objeto Autor con los datos del resultado
            $autor = new Autor($row['id'], $row['nombre'], $row['apellido']);
            $autores[] = $autor; // Agrega el objeto Autor al arreglo de autores
        }
    }

    return $autores; // Devolvemos el arreglo de objetos de autor
}
?>