<?php
function ListarCristal($vConexion) {

    $Listado=array();

    $SQL = "SELECT id_cristal, tipo_cristal, precio FROM cristales ";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDCRIS'] = $data['id_cristal'];
            $Listado[$i]['TIPOCRIS'] = $data['tipo_cristal'];
            $Listado[$i]['PRECIOCRIS'] = $data['precio'];
            
            $i++;
    }


    return $Listado;

}
?>