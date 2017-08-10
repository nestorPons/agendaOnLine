<?php
header('Content-Type: application/json'); 
require('../../connect/conexion.php');
$conexion = conexion( $security=false,$bd=$_POST['empresa']);
require('../../config.php');

$pass1 = $_POST["pass1"]??"";
$pass2 = $_POST["pass2"]??false;
$nombre = trim($_POST['nombre'])??false;
$email = trim($_POST['email'])??false;
$tel = $_POST['tel']??0;
$empresa = CONFIG['nombre'];
$rsp['success'] = false;

if ($pass1==$pass2){
	$sql = "INSERT INTO usuarios (nombre,Email,Pass,dateReg,Tel) VALUE ('$nombre','$email','$pass1','" . date('Y-m-d') ."','$tel');";
	$rsp['sql']=$sql;
	if(mysqli_query($conexion,$sql)){					
		$id = mysqli_insert_id($conexion);
		//$rsp['registrarEvento'] = registrarEvento(3, 0, $id,0);
		if($nombre != "" && $email != ''){
			//Cabeceras del correo
			$headers = "From: $empresa ".CONFIG['Email']." \r\n"; 
			$headers .= "MIME-Version: 1.0 \r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8 " ." \r\n";			
			
			$asunto = "Confirmacion de usuario";//Puedes cambiar el asunto del mensaje desde aqui
			//Este sería el cuerpo del mensaje
			$mensaje = "<html><head></head><body> Email de confirmación en para la agendaOnLine de $empresa </br>
			Para confirmar su registro pulse en el siguiente link: </br>
			<a href='".$_SERVER['SERVER_NAME']."/$empresa/confirmacion.html?id=$id'>Confirmacion</a>
			</body></html>;";
			//$mensaje = preg_replace("[\n|\r|\n\r]",' ',$mensaje);
			$rsp['e']=$empresa;
			$rsp['success'] = mail($email, $asunto, $mensaje, $headers);
		}
	}
}
echo json_encode($rsp);