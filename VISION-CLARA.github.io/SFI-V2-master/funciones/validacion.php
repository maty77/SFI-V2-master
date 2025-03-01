<?php
function validar_Datos() {
    $vMensaje='';
    
    if (is_numeric($_POST['ContactoUser']) == ($_POST['ContactoUser'])< 99999) {
        $vMensaje.='Debes ingresar una patente de 6 digitos. <br />';
    }


    return $vMensaje;
}



?>