<?php
function ListarProvincia($vConexion) {

    $Listado=array();

    $SQL = "SELECT Id_Prov, Provincia_Desc FROM Provincia";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDPROV'] = $data['Id_Prov'];
            $Listado[$i]['PROVINCIA'] = $data['Provincia_Desc'];
            $i++;
    }


    return $Listado;

}
?>