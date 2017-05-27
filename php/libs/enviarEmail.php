<?php
$sql="SELECT * FROM usuarios WHERE Id=$id_usuario";
if ($user=mysqli_fetch_array(mysqli_query($conexion,$sql))){
	if (!empty ($user['Email'])){
		$arrayHoras = (isset($_GET['hora']))?$_GET['hora']:$_GET['hora'];
		$horas = HORAS[$arrayHoras[0]];	
		$link = $_SERVER["SERVER_NAME"].'/AOL/plantilla/index.html';
		$titulo = 'Confirmación de la cita';
		$titulo = "=?utf-8?B?".base64_encode($titulo)."=?=";
		$para = $user['Email'];
		$cabeceras = 'MIME-Version: 1.0' . PHP_EOL;
		$cabeceras .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
		$cabeceras .= 'From: '.CONFIG['nombre'].'<'.CONFIG['Email'].'>'. PHP_EOL;
		$mensaje = 
				'<html>
				<head>
				<title>Reserva cita en '. CONFIG['Nombre'] .'</title>
				</head>
				<body style="text-aling:center">
				<h1>Reserva cita en Le Bouquet</h1>
				Le informamos que tiene su cita reservada para el día:
				</br>
				<h2>'.$fecha.' a las '.$horas.'</h2>
				</br>
				Puede proceder a la modificación o eliminación en:
				</br>
				<h2>
				<a href="'.$link.'">Agenda On Line</a>
				</h2>
				</br>
				
				Si piensa que este email pudiera tratarse de un error,  comuniquelo al centro, llamando al '.CONFIG['Tel'].' o mandando un email a '.CONFIG['Email'].'</br>
				Gracias </br>
				
				
				AVISO LEGAL: 
				</br>
				 Este mensaje y los ficheros anexos se dirigen exclusivamente a su destinatario y pueden contener información privilegiada o confidencial.
				 Si no es vd. el destinatario indicado, queda notificado de que la utilización, divulgación y/o copia sin autorización está prohibida en virtud de la legislación vigente.
				 Si ha recibido este mensaje por error, le rogamos nos lo comunique inmediatamente por esta misma vía y proceda a su destrucción.
				 De conformidad a la L.O.P.D. 15/99 de 13 de diciembre, le informamos que sus datos están almacenados en un fichero, registrado, 
				 del que es propietario y responsable '.CONFIG['NomUser'].' Podrá ejercitar los derechos de acceso, 
				 rectificación, cancelación y oposición reconocidos en el RD 1720/2007 del 21 de diciembre de 2007 
				 sobre protección de Datos de Carácter Personal, mediante comunicado por escrito a  '.CONFIG['Dir'].'.
				</body>
				</html>';
		

		$enviado = mail($para, $titulo, $mensaje,$cabeceras);
	}
}