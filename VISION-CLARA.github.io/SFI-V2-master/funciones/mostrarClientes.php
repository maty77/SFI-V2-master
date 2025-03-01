<?php
function ListarClientes($vConexion) {

    $Listado=array();

    $SQL = "SELECT c.NOMBRE, c.APELLIDO, c.DNI_CLI, c.CIUDAD, p.Provincia_desc, c.contacto, c.Disponibilidad, c.Email
    FROM cliente c, provincia p 
    WHERE p.id_prov=c.id_prov
    ORDER BY c.apellido ASC";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['NOM_CLI'] = $data['NOMBRE'];
            $Listado[$i]['APE_CLI'] = $data['APELLIDO'];
            $Listado[$i]['DNI_CLI'] = $data['DNI_CLI'];
            $Listado[$i]['PROVINCIA'] = $data['Provincia_desc'];
            $Listado[$i]['CIU_CLI'] = $data['CIUDAD'];
            $Listado[$i]['CON_CLI'] = $data['contacto'];
            $Listado[$i]['MAIL_CLI'] = $data['Email'];
            $Listado[$i]['DISPO_CLI'] = $data['Disponibilidad'];

            $i++;
    }


    return $Listado;

}




?>