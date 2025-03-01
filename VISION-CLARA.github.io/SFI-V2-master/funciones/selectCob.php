<?php
function ListarCobertura($vConexion) {

    $Listado=array();

    $SQL = "SELECT id_cob, cobertura FROM cobertura";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDCOB'] = $data['id_cob'];
            $Listado[$i]['COB'] = $data['cobertura'];
            $i++;
    }


    return $Listado;

}
?>