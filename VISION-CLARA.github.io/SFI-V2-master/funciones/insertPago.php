<?php 
function InsertarCliente($vConexion){

    $SQL_Insert="INSERT INTO tipopago (PAGO )
    VALUES ('".$_POST['T_PAGO']."')";

if (!mysqli_query($vConexion, $SQL_Insert)) {
    return false;
}
return true;

}

?>