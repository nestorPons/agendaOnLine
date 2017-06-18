<?php 
require "../php/connectconnect/conexion.php";
$_SESSION['id_usuario'] = $_GET['idusuario'];
$conexion = conexion( $security=false,$bd=$_GET['e']);

$token = $_GET['token'];
$idusuario = $_GET['idusuario'];

$sql = "SELECT * FROM tblreseteopass WHERE token = '$token'";
$resultado = mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado)> 0){
	$usuario = mysqli_fetch_assoc($resultado);
	if( sha1($usuario['idusuario']) == $idusuario ){
?>
<!DOCTYPE html>
<html lang="es" >	
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Agenda OnLine</title>
<link rel='shortcut icon' href='../../img/favicon.ico' >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet"  type="text/css" href="../../css/index.css">
<script  type="text/javascript" src="../../js/start.js" async ></script>

</head><body>
	<div class="login-form">
	  <h1>Cambiar contraseña</h1>
			<div class="iconClass-container icon-left">
				<input type="password" id="fakePass" name="fakePass" placeholder="Introduzca su nueva contraseña">	
				<span class="iconClass-inside icon-eye"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="password" id="fakePass2" name="fakePass2" placeholder="Repita su nueva contraseña">	
				<span class="iconClass-inside icon-eye"></span>
			</div>
		
		<form id="frmCambiarPass" action="cambiarpassword.php" method="post">
			<input type="hidden"  name="pass2" id="pass2">
			<input type="hidden"  name="pass" id="pass">
		   <input type="hidden" name="token" value="<?php echo $token ?>">
			<input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
		</form>  
			<p class="submit">
				<button type="button"  id="cambiarPass" class="btn-success btnLoad" value="Recuperar" ></button>
			<p>

	 </div>
</body></html>
		<?php
		}else{
				echo "fallo n1";
			//header('Location:index.html');
		}
	}else{
			echo "fallo n2";
	//	header('Location:index.html');
	}
?>