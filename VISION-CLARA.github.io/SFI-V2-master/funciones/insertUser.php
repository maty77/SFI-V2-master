<?php 
function InsertarUsuario($vConexion){
    $valor = !empty($_POST['Numero'])? $_POST['Numero']:'';
    $Dispo = !empty($_POST['Disponibilidad'])? $_POST['Disponibilidad']:'';

    $SQL_Insert="INSERT INTO Usuario (DNI_U, ID_JER, ID_PROV, Contrasena, Nombre, Apellido, Usuario, Contacto, Domicilio, Ciudad, Disponibilidad )
    VALUES (".$_POST['DNI'].",".$valor.",".$_POST['Provincia'].", '".$_POST['ContraUser']."','".$_POST['NombreUser']."','".$_POST['ApellidoUser']."', '".$_POST['EmailUser']."',".$_POST['ContactoUser'].", '".$_POST['DomicilioUser']."','".$_POST['CiudadUser']."',".$Dispo." )";


if (!mysqli_query($vConexion, $SQL_Insert)) {
    return false;
}
return true;

}

?>