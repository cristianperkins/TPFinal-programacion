<?php 

$query = "SELECT libros.titulo, libros.descripcion, libros.precio, libros.fecha_publicacion, libros.portada, autor.nombre AS autor_nombre, autor.apellido AS autor_apellido, categorias.nombre AS categoria_nombre
          FROM libros
          INNER JOIN autor ON libros.autor_id = autor.id
          INNER JOIN categorias ON libros.categoria_id = categorias.id
          WHERE libros.id = :book_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
$stmt->execute();
$libro_comprado = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['precio'] = $libro_comprado['precio']; // Establece el precio en la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesa el formulario de compra aquí
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $email_confirmation = $_POST['email_confirmation'];

        // Establecer una variable para errores
        $errors = [];

        // Validación de campos para mensajes de error
        if (empty($nombre)) {
            $errors['nombre'] = "El nombre es requerido.";
        } elseif (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
            $errors['nombre'] = "El nombre no debe contener símbolos o números. Solo se permiten letras y espacios.";
        }
    
        if (empty($apellido)) {
            $errors['apellido'] = "El apellido es requerido.";
        } elseif (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $apellido)) {
            $errors['apellido'] = "El apellido no debe contener símbolos o números. Solo se permiten letras y espacios.";
        }
    
        if (empty($direccion)) {
            $errors['direccion'] = "La dirección es requerida.";
        } elseif (preg_match('/^\d/', $direccion)) {
            $errors['direccion'] = "La dirección no puede comenzar con números.";
        }
    
        if (empty($ciudad)) {
            $errors['ciudad'] = "La ciudad es requerida.";
        } elseif (!preg_match('/^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$/', $ciudad)) {
            $errors['ciudad'] = "La ciudad no debe contener símbolos o números.";
        }
    
        if (empty($codigo_postal)) {
            $errors['codigo_postal'] = "El código postal es requerido.";
        } elseif (!is_numeric($codigo_postal) || strlen($codigo_postal) !== 4) {
            $errors['codigo_postal'] = "El código postal debe contener 4 números.";
        }
    
        if (empty($telefono)) {
            $errors['telefono'] = "El teléfono es requerido.";
        } elseif (!is_numeric($telefono) || strlen($telefono) < 10) {
            $errors['telefono'] = "El teléfono debe contener al menos 10 números.";
        }
    
        if (empty($email)) {
            $errors['email'] = "El E-mail es requerido.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "El E-mail es inválido, ingresa uno válido.";
        }
    
        if (empty($email_confirmation)) {
            $errors['email_confirmation'] = "La confirmación del E-mail es requerida.";
        } elseif ($email !== $email_confirmation) {
            $errors['email_confirmation'] = "La confirmación del E-mail no coincide con el E-mail ingresado.";
        }
    
        if (empty($errors)) {
            // Mostrar mensaje de compra exitosa
            echo '<script>';
            echo 'alert("Gracias por comprar el libro ' . $libro_comprado['titulo'] . '. Esté atento a su correo electrónico para el seguimiento de la compra. Gracias por confiar en nuestro servicio.");';
            echo 'window.location.href = "../index.php";'; // Redirige al índice
            echo '</script>';
        }
    }

?>