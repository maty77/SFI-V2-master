<?php 
function InsertarAdmin($vConexion){
    $Dispo = !empty($_POST['Disponibilidad'])? $_POST['Disponibilidad']:'';

    $SQL_Insert="INSERT INTO Usuario (DNI_U, ID_JER, ID_PROV, Contrasena, Nombre, Apellido, Usuario, Contacto, Domicilio, Ciudad, Disponibilidad )
    VALUES (".$_POST['DNIadmin'].",".$_POST['Jerarquia'].",".$_POST['Provincia'].", '".$_POST['PASSadmin']."','".$_POST['NOMadmin']."','".$_POST['APEadmin']."', '".$_POST['EMAILadmin']."',".$_POST['CONTadmin'].", '".$_POST['DOMadmin']."','".$_POST['CIUadmin']."', ".$Dispo." )";



        if (!mysqli_query($vConexion, $SQL_Insert)) {
    return false;
    }
    return true;
}



?>