<?php
function ListarProveedores($vConexion) {

    $Listado=array();

    $SQL = "SELECT p.id_proveedor, prov.Provincia_desc, p.proveedor, p.contacto, p.domicilio, p.ciudad, p.Email, p.Disponibilidad
    FROM proveedor p, provincia prov
    WHERE p.Id_Prov=prov.Id_Prov 
    ORDER BY p.Proveedor ASC";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID_PROVE'] = $data['id_proveedor'];
            $Listado[$i]['PROVEEDOR'] = $data['proveedor'];
            $Listado[$i]['PROVINCIA'] = $data['Provincia_desc'];
            $Listado[$i]['CON_PROV'] = $data['contacto'];
            $Listado[$i]['DOM_PROV'] = $data['domicilio'];
            $Listado[$i]['CIU_PROV'] = $data['ciudad'];
            $Listado[$i]['EMAIL_PROV'] = $data['Email'];
            $Listado[$i]['DISPO_PROV'] = $data['Disponibilidad'];

            $i++;
    }


    return $Listado;

}




?>