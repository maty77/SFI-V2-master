<?php 
function InsertarCliente($vConexion){
    $Dispo = !empty($_POST['Disponibilidad'])? $_POST['Disponibilidad']:'';

    $SQL_Insert="INSERT INTO Cliente (DNI_CLI, ID_PROV, NOMBRE, APELLIDO, CONTACTO, DOMICILIO, CIUDAD, Disponibilidad, Email )
    VALUES (".$_POST['DNI'].", ".$_POST['Provincia'].",'".$_POST['NombreCli']."','".$_POST['ApellidoCli']."',".$_POST['ContactoCli'].", '".$_POST['DomicilioCli']."','".$_POST['CiudadCli']."',".$Dispo.",  '".$_POST['EmailCli']."')";




if (!mysqli_query($vConexion, $SQL_Insert)) {
    return false;
}
return true;

}

?>