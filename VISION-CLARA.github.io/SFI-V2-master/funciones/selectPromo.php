<?php
function ListarPromo($vConexion) {

    $Listado=array();

    $SQL = "SELECT id_promo, promo, terminos, valor_descuento, activo FROM promociones";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDPROMO'] = $data['id_promo'];
            $Listado[$i]['PROMO'] = $data['promo'];
            $Listado[$i]['TERMINOS'] = $data['terminos'];
            $Listado[$i]['VALOR'] = $data['valor_descuento'];
            $Listado[$i]['DISPO'] = $data['activo'];
            $i++;
    }


    return $Listado;

}
?>