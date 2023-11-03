<?php
function obtenerNombreDeUsuario($user_id, $conn) {
    // Consultamos para obtener el nombre del usuario
    $sql = "SELECT nombre_usuario FROM usuarios WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nombre_usuario'];
    }

    return null; // Retorna null si el usuario no se encuentra en la base de datos
}

function esAdmin($user_id, $conn) {
    $sql = "SELECT id FROM admin WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount() === 1;
}
?>