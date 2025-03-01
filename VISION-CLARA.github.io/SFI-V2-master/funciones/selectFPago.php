<?php
function ListarFPago($vConexion) {

    $Listado=array();

    $SQL = "SELECT Id_pago, pago FROM tipopago";

     $rs = mysqli_query($vConexion, $SQL);
        
    
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDFP'] = $data['Id_pago'];
            $Listado[$i]['PAGO'] = $data['pago'];
            $i++;
    }


    return $Listado;

}
?>