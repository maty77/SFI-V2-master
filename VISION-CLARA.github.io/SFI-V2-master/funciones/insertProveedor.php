<?php 
function InsertarProveedor($vConexion){
    $Dispo = !empty($_POST['Disponibilidad'])? $_POST['Disponibilidad']:'';

    $SQL_Insert="INSERT INTO Proveedor (Id_Proveedor, Id_Prov, Proveedor, Contacto, Domicilio, Ciudad, Email, Disponibilidad)
    VALUES (".$_POST['CUIT'].",".$_POST['Provincia'].", '".$_POST['Proveedor']."',".$_POST['ContactoProv'].", '".$_POST['DomicilioProv']."', '".$_POST['CiudadProv']."','".$_POST['EmailProv']."',".$Dispo." )";


if (!mysqli_query($vConexion, $SQL_Insert)) {
    return false;
}
return true;

}

?>