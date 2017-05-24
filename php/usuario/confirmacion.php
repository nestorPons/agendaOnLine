<?php 
header('Content-Type: application/json'); 
require('../../php/connectconnect/conexion.php');
$conexion = $conexion = conexion( );;
$sql="UPDATE usuarios SET Activa=1 WHERE Id = ". $_GET['id'];
$result = mysqli_query($conexion,$sql);

function getFolder() {
	$path = $_SERVER['PHP_SELF'];
	$file = dirname($path);
	return substr($file,1);
}
function srcLogo(){
	if (file_exists("arch/logo.png")){
		$path = "arch/logo.png";
	}else if (file_exists("arch/logo.jpg")){
		$path = "arch/logo.jpg";
	}else{
		$path = "../img/logo.png";
	}
	 return $path;
}
?>	
<!DOCTYPE html>
<html lang="es"><head>
<link rel="icon" href="img/favicon.ico">
<meta name="description" content="La agenda para los centros de belleza, peluquerias, centros de masaje, terapeuticos y más.">
<title>Agenda On Line</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='shortcut icon' href='../img/favicon.ico' >
<link rel="stylesheet"  type="text/css" href="../css/index.css">
<title>Nuevo usuario</title>
</head><body id= "nuevoUsuario" >
    <div class="login-form">	
		<img src="<?php echo srcLogo()?>"  width=64>
		<h1 class="heading">Bienvenido</h1>
		
		<input type="hidden" id="empresa"  value="<?php echo getFolder() ?>">
		<p>Nuevo usuario registrado con éxito!<p>
		<p>Para poder empezar a coger su cita On Line dirijase al login principal</p>
			<a href  = "index.php" >Ir al la pagina de inicio</a>
		</p>
    </div>
</body></html>