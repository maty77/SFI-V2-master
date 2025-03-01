<?php
function ListarEntrega($vConexion) {

    $Listado=array();

    $SQL = "SELECT id_ent, entrega FROM tipoentrega";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDEN'] = $data['id_ent'];
            $Listado[$i]['ENTREGA'] = $data['entrega'];
            $i++;
    }


    return $Listado;

}
?>