
<?php
$link = $_SERVER["SERVER_NAME"].'/agenda/pass/restablecer.php?idusuario=867cd58f3fe352905cc5b21cb41c523ca92da469&token=abb971c921a4b0eb39c99097437916336513b3c8';

$email = "nestorpons@hotmail.es";
$mensaje = '<html>
		<head>
 			<title>Restablece tu contraseña</title>
		</head>
		<body>
 			<p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
 			<p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
 			<p>
 				<strong>Enlace para restablecer tu contraseña</strong><br>
 				<a href="'.$link.'"> Restablecer contraseña </a>
 			</p>
		</body>
		</html>';
		$cabeceras = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras = 'From: Proba.php <admin@lebouquet.es>' . "\r\n";
if(mail($email, "Recuperar contraseña", $mensaje, $cabeceras))
    echo "Email sent";
else
    echo "Email sending failed";
?>