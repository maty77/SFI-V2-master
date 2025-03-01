<?php 
function InsertarPromo($vConexion){
$codpromo = mysqli_real_escape_string($vConexion, $_POST['CODPROMO']);
$promo = mysqli_real_escape_string($vConexion, $_POST['PROMO']);
$term = mysqli_real_escape_string($vConexion, $_POST['TERM']);
$desc = (int) $_POST['DESC']; 
$activo = (int) $_POST['Activo']; 

            $SQL_Insert="INSERT INTO  promociones (id_promo, promo, terminos, valor_descuento, activo )
                            VALUES ('$codpromo', '$promo','$term','$desc','$activo')";

if (!mysqli_query($vConexion, $SQL_Insert)) {
    return false;
}
return true;

}

?>