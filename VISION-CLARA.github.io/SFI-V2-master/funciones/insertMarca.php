<?php 
function InsertarMarca($vConexion){
$marca = mysqli_real_escape_string($vConexion, $_POST['MARCA']);
$estatus = mysqli_real_escape_string($vConexion, $_POST['ESTATUS']);
$activo = (int) $_POST['Activo']; 

            $SQL_Insert="INSERT INTO  marca (marca, id_estatus, disponibilidad)
                            VALUES ('$marca', '$estatus','$activo')";

if (!mysqli_query($vConexion, $SQL_Insert)) {
    return false;
}
return true;

}

?>