<?php  
function DatosLogin($vUsuario, $vClave, $vConexion){
	$Usuario=array();
	$SQL="SELECT u.DNI_U, u.Disponibilidad, u.Nombre, u.Apellido, j.Jerarquia, u.id_jer
	FROM usuario u, jerarquia j
	WHERE Usuario='$vUsuario' AND Contrasena='$vClave' AND u.Id_Jer=j.Id_Jer AND u.disponibilidad=1";
	$rs = mysqli_query($vConexion, $SQL);

	$data = mysqli_fetch_array($rs);
	if (!empty($data)){
		$Usuario['DNI_U'] = $data['DNI_U'];
        $Usuario['DISPONIBILIDAD'] = $data['Disponibilidad'];
        $Usuario['NOMBRE'] = $data['Nombre'];
        $Usuario['APELLIDO'] = $data['Apellido'];
        $Usuario['JERARQUIA'] = $data['Jerarquia'];
        $Usuario['IDJER'] = $data['id_jer'];
        $Usuario['USUARIO'] = $data['Usuario'];
        }
        

    return $Usuario;
}



?>