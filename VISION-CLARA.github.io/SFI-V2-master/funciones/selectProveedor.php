<?php
function ListarProve($vConexion) {

    $Listado=array();

    $SQL = "SELECT Id_Proveedor, Proveedor FROM proveedor WHERE Disponibilidad = 1";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDPROVE'] = $data['Id_Proveedor'];
            $Listado[$i]['PROVEEDOR'] = $data['Proveedor'];
            $i++;
    }


    return $Listado;

}
?>