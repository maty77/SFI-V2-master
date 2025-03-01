<?php
function ListarEstatus($vConexion) {

    $Listado=array();

    $SQL = "SELECT e.id_estatus, e.estatus FROM Estatus e ";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDESTATUS'] = $data['id_estatus'];
            $Listado[$i]['ESTATUS'] = $data['estatus'];

            $i++;
    }


    return $Listado;

}
?>