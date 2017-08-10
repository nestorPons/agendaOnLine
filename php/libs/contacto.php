<?php
header('Content-Type: application/json');
$nombre = $_POST['nombre']??"";
$email = $_POST['email']??"";
$telefono = $_POST['telefono']??"";
$ciudad = $_POST['ciudad']??"";
$pais = $_POST['pais']??"";
$mensaje = $_POST['mensaje']??"";
$empresa = $_POST['empresa']??"";
$rsp['s'] = false;
	///Validamos del lado del servidor que el nombre y el email no estén vacios
if($nombre != "" && $email != ''){
	$para = "nestorpons@gmail.com";//Email al que se enviará
	$asunto = "solicitud contacto $empresa";//Puedes cambiar el asunto del mensaje desde aqui
	//Este sería el cuerpo del mensaje
	$mensaje = "<html><body><table border='0' cellspacing='3' cellpadding='2'>".
	"<tr><td width='30%' align='left' bgcolor='#f0efef'><strong>nombre:</strong></td>".
		"<td width='80%' align='left'>$nombre</td></tr>".
	"<tr><td align='left' bgcolor='#f0efef'><strong>E-mail:</strong></td>".
		"<td align='left'>$email</td></tr>".
	"<tr><td align='left' bgcolor='#f0efef'><strong>Empresa:</strong></td>".
	"	<td align='left'>$empresa</td></tr>".
	"<tr><td width='30%' align='left' bgcolor='#f0efef'><strong>Teléfono:</strong></td>".
	"	<td width='70%' align='left'>$telefono</td></tr>".
	"<tr><td width='30%' align='left' bgcolor='#f0efef'><strong>Ciudad:</strong></td>".
		"<td width='70%' align='left'>$ciudad</td></tr>".
	"<tr><td width='30%' align='left' bgcolor='#f0efef'><strong>País:</strong></td>".
	"<td width='70%' align='left'>$pais</td></tr>".
	"<tr><td align='left' bgcolor='#f0efef'><strong>Comentario:</strong></td>".
	"<td align='left'>$mensaje</td></tr></table></body></html>;";
$rsp['m']=$mensaje;
//Cabeceras del correo
    $headers = "From: $nombre <$email>\r\n"; 
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
//Comprobamos que los datos enviados a la función MAIL de PHP estén bien y si es correcto enviamos
	if(mail($para, $asunto, $mensaje, $headers)){$rsp['s'] = true;}
}
echo json_encode($rsp);