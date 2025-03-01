<?php 
require_once 'funciones/conexion.php';
$MiConexion=ConexionBD();
session_start();


$Mensaje='';
if (!empty($_POST['BotonLogin'])) {
 require_once 'funciones/login.php';
$UsuarioLogueado = DatosLogin($_POST['Usuario'], $_POST['Contrasena'], $MiConexion);

 if ( !empty($UsuarioLogueado)) {
 $Mensaje ='ok! ya puedes ingresar';

//generar los valores del usuario (esto va a venir de mi BD)
$_SESSION['Usuario_Nombre']=$UsuarioLogueado['NOMBRE'];
$_SESSION['Usuario_Apellido']=$UsuarioLogueado['APELLIDO'];
$_SESSION['Usuario_DNI_U']=$UsuarioLogueado['DNI_U'];
$_SESSION['Usuario_Jerarquia']=$UsuarioLogueado['JERARQUIA'];
$_SESSION['Usuario_Disponibilidad']=$UsuarioLogueado['DISPONIBILIDAD'];
$_SESSION['Usuario_id_jer']=$UsuarioLogueado['IDJER'];



if ($UsuarioLogueado['DISPONIBILIDAD']==0) {
     $Mensaje ='Ud. no se encuentra activo en el sistema.';
}else {
  header('Location: home.php');
exit;
}

}else {
 $Mensaje='Datos incorrectos, ingresa nuevamente.';
    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/sweetalert2.css">
	<link rel="stylesheet" href="css/material.min.css">
	<link rel="stylesheet" href="css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
	<script src="js/material.min.js" ></script>
	<script src="js/sweetalert2.min.js" ></script>
	<script src="js/jquery.mCustomScrollbar.concat.min.js" ></script>
	<script src="js/main.js" ></script>
</head>
<body>
	<div class="login-wrap cover" >
		<div class="container-login">
			<p class="text-center" style="font-size: 80px;">
				<i class="zmdi zmdi-account-circle"></i>
			</p>
			<p class="text-center text-condensedLight">INGRESE CON SU CUENTA</p>
			
 <form role="form" method='post'>
				 
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    <input class="mdl-textfield__input" type="text" id="EMAIL" name="Usuario" required>
				    <label class="mdl-textfield__label" for="userName">USUARIO</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    <input class="mdl-textfield__input" type="password" id="PASS" name="Contrasena" required>
				    <label class="mdl-textfield__label" for="pass">CONTRASEÑA</label>
				</div>
				<button type="submit"  style="color: #3F51B5; margin: 0 auto; display: block;" name="BotonLogin" value="Login">
					ENTRAR
				</button>
			</form>

		</div>
	</div>
</body>
</html>