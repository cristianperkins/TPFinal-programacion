<?php
class FormValidacion {
    // Verificamos si el campo esta vació (email)
    public function isEmpty($valor, $nombre_variable) {
        if (empty($valor)) {
            // Si el campo está vacío, se devuelve un mensaje de error
            return "El ".$nombre_variable." es requerido.";
        }
        // Si no hay error, se retorna null
        return null;
    }

    // Verificamos si el campo esta vació (contraseña)
    public function isPasswordEmpty($valor, $nombre_variable) {
        if (empty($valor)) {
            // Si el campo está vacío, se devuelve un mensaje de error
            return "La ".$nombre_variable." es requerida.";
        }
        // Si no hay error, se retorna null
        return null;
    }
}
?>