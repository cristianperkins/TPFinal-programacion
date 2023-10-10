<?php
function subir_archivo($archivo, $directorio_destino) {
    $nombre_archivo = $archivo['name'];
    $nombre_temporal = $archivo['tmp_name'];
    $error = $archivo['error'];

    // Define las extensiones permitidas para imágenes
    $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');

    if ($error === 0) {
        $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        if (in_array($extension, $extensiones_permitidas)) {
            $nombre_archivo_final = uniqid("", true) . '.' . $extension;
            $ruta_destino = $directorio_destino . '/' . $nombre_archivo_final;
            move_uploaded_file($nombre_temporal, $ruta_destino);

            $resultado_subida['estado'] = 'éxito';
            $resultado_subida['archivo'] = $nombre_archivo_final;

            return $resultado_subida;
        } else {
            $resultado_subida['estado'] = 'error';
            $resultado_subida['mensaje'] = "No se pueden subir archivos de este tipo. Solo se permiten imágenes.";

            return $resultado_subida;
        }
    } else {
        $resultado_subida['estado'] = 'error';
        $resultado_subida['mensaje'] = 'Error al subir el archivo';

        return $resultado_subida;
    }
}
?>