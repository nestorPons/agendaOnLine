<?php 
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
<html lang="es" ><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Agenda onLine para pymes">
    <meta name="author" content="Nestor Pons">
	
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico"  />
	<link type="text/css" rel="stylesheet" href="../fontello/css/iconos.css">
	<link href="../css/index.css" rel="stylesheet">
	
    <title>Nuevo usuario</title>
</head><body id= "nuevoUsuario" >
    <div class="login-form">	
		<a href="index.php">
			<img src="<?php echo srcLogo()?>"  width=64>
		</a>
		<h1 class="heading">Registro nuevo usuario</h1>

		<form id="form">
		<input type="hidden" id="empresa"  value="<?php echo getFolder() ?>">
			<div class="iconClass-container icon-left">
				<input type="text" class="nombre" id="nombre" placeholder="Introduzca nombre y apellidos." required >
					
				<span class="iconClass-inside icon-user-1"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="Email" class="email" id="email" placeholder="Introduzca email." required>
				<span class="iconClass-inside icon-mail-1"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="tel" class="tel" id="tel"  	title="Un numero telefono válido!!"	placeholder="Telefono de contacto" >
				<span class="iconClass-inside icon-phone"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="password" id="pass1Fake"  placeholder="Introduzca contraseña" required>
				<input type="hidden" id="pass1">
				<span class="iconClass-inside icon-eye"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="password" id="pass2Fake"  placeholder="repita contraseña" required>
				<input type="hidden" id="pass2">
				<span class="iconClass-inside icon-eye"></span>
			</div>
			 <p>
				<input type="button" class="btn-danger inicio cancel" name="cancelar" id="cancelar" value="Cancelar" >
				<button type="submit" class="btn-success btnLoad" id="btnGuardarCita" data-value="Guardar">Guardar</button>
			 </p>
      </form>
    </div>
	<script  type="text/javascript" src="../js/start.js" ></script>
</body></html>