<?php
function ListarPagos($vConexion) {

    $Listado=array();

    $SQL = "SELECT tp.Pago
    FROM tipopago tp
    ORDER BY tp.Pago ASC";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['TP_PAGO'] = $data['Pago'];

            $i++;
    }


    return $Listado;

}
