<?php 
include "../php/connectconnect/conexion.php";
$conexion = conexion( $security=false,$bd=$_SESSION['bd'] );

$password1 = $_POST['pass'];
$password2 = $_POST['pass2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];

if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
?>
<!DOCTYPE html>
<html lang="es"><head>
<link rel='shortcut icon' href='../../img/favicon.ico' >
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	  <link rel="stylesheet"  type="text/css" href="../../css/estilos.css">
	  <meta name="author" content="DashFox">	  
</head> <body>
    <div class="login-form" role="main"> 
<?php
	$sql = " SELECT * FROM tblreseteopass WHERE token = '$token' ";
	$resultado = mysqli_query($conexion,$sql);
	
	if(mysqli_num_rows($resultado)> 0){
		$usuario = mysqli_fetch_assoc($resultado);
		if( sha1( $usuario['idusuario'] === $idusuario ) ){
			if( $password1 === $password2 ){
				$sql = "UPDATE usuarios SET Pass = '".sha1($password1)."' WHERE Id = ".$usuario['idusuario'];
				$resultado = mysqli_query($conexion,$sql);
				if($resultado){
					$sql = "DELETE FROM tblreseteopass WHERE token = '$token';";
					$resultado = mysqli_query($conexion,$sql);
					header('Location:../index.php?cp=true');
				}else{
				?>
					<p> Ocurrió un error al actualizar la contraseña, intentalo más tarde </p>
				<?php
				}
			}
			else{
			?>
			<p> Las contraseñas no coinciden </p>
			<?php
			}

		}
		else{
?>
<p> La sesion ha expirado vuelva a intentarlo más tarde</p>
<?php
		}	
	}
	else{
?>
<p>  La sesion ha expirado vuelva a intentarlo más tarde </p>
<?php
	}
	?>
<div class="login-help">
	<a class="login-help" href="../index.html"> Ir a la página de inicio. </a>
</div>
	</div> <!-- /container -->
  </body></html>
<?php
}else{
	header('Location:login.php');
}
?>