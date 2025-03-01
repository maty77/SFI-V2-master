<?php
function ListarTrat($vConexion) {

    $Listado=array();

    $SQL = "SELECT id_trat, tipo_trat, precio FROM tratamientos ";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDTRAT'] = $data['id_trat'];
            $Listado[$i]['TIPOTRAT'] = $data['tipo_trat'];
            $Listado[$i]['PRECIOTRAT'] = $data['precio'];
            
            $i++;
    }


    return $Listado;

}
?>