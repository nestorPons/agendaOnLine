<?php
require('../connect/conexion.php');
$conexion = conexion( $security=false,$bd=$_GET['empresa'],$tools = true);

function generarLinkTemporal($idusuario, $username){
	global $conexion;
	$cadena = $idusuario.$username.rand(1,9999999).date('Y-m-d');
	$token = sha1($cadena);
	$sql = "INSERT INTO tblreseteopass (idusuario, token, creado) VALUES($idusuario,'$token','".date('Y-m-d H:i:s')."');";
	if($resultado = mysqli_query($conexion,$sql)){
		 $enlace = $_SERVER['SERVER_NAME']."/".$_SESSION['bd'].'/restablecer.php?e='.normaliza(CONFIG['Nombre']).'&idusuario='.sha1($idusuario).'&token='.$token;
		return $enlace;
	}else{
		return false;
	}
}
function enviarEmail($email,$link){
	$mensaje = '<html><head>
							<title>Restablece tu contraseña</title>
						</head><body>
							<h1>Restablece tu contraseña</h1>
							<p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
							<p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
							<p><strong>Enlace para restablecer tu contraseña:</strong></p>
							<a href="'.$link.'"> Restablecer contraseña</a>
							<hr>
							
							<span>
							AVISO LEGAL:
							En cumplimiento de lo establecido en la L.O. 15/1999 de Protección de Datos de Carácter Personal, '.CONFIG["Nombre"].
							' le informa que sus datos han sido incorporados a un fichero automatizado con la finalidad de prestar y ofrecer nuestros servicios. 
							Los datos recogidos son almacenados bajo la confidencialidad y las medidas de seguridad legalmente establecidas y no serán cedidos ni compartidos con empresas 
							ni entidades ajenas a '.CONFIG["Nombre"].'. Igualmente deseamos informarle que podrá ejercer los derechos de acceso, 
							rectificación cancelación u oposición a través de los siguientes medios:
							
							• E-mail:'.CONFIG["Email"].'

							• Comunicación escrita al responsable legal del fichero:'.CONFIG["Dir"].'
							</span>
						</body></html>';
						
	$cabeceras = 'MIME-Version:1.0' . "\r\n";
	$cabeceras .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
	$cabeceras .= 'From:'. CONFIG['Nombre'].'<'.CONFIG['Email'].'>';
	$asunto = "Nueva contraseña";
	$asunto = "=?UTF-8?B?".base64_encode($asunto)."=?=";
	mail($email, $asunto, $mensaje, $cabeceras);
}

if( $_GET['email'] != "" ){
	$sql = " SELECT * FROM usuarios WHERE Email LIKE '".$_GET['email']."' ";
	$resultado = $conexion->query($sql);
	if($resultado->num_rows > 0){
		$usuario = $resultado->fetch_assoc();
		$linkTemporal = generarLinkTemporal( $usuario['Id'], $usuario['Nombre'] );
		if($linkTemporal){
			enviarEmail( $_GET['email'], $linkTemporal );
			$respuesta = "Un correo ha sido enviado a su cuenta de email con las instrucciones para restablecer la contraseña";
		}
	}else{
		$respuesta = 'No existe una cuenta asociada a ese correo.';
	}
}else{
	$respuesta= "Debes introducir el email de la cuenta";
}
?>
<!DOCTYPE html>
<html lang="es" >	
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Agenda OnLine</title>
<link rel='shortcut icon' href='../../img/favicon.ico' >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet"  type="text/css" href="../css/index.css">
<script type="text/javascript" src="../js/start.js"></script>

</head><body>
	<div class="login-form">	
		<img id="logo" src="../img/logo.png"   width="64">
		<h1 class="heading">Compruebe su correo</h1>
		<table class ="aling-center">
			<div><?php echo($respuesta); ?></div>
		</table>
		<p class="submit"><a href="index.php">Ir a inicio</a></p>
	</div>	
</body></html>
 	
