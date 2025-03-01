<?php
function ListarTipoProd($vConexion) {

    $Listado=array();

    $SQL = "SELECT id_tipoprod, tipoproducto_desc FROM tipoproducto";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDTIPO'] = $data['id_tipoprod'];
            $Listado[$i]['TIPODESC'] = $data['tipoproducto_desc'];
            $i++;
    }


    return $Listado;

}
?>