<?php
session_start ();
$url_empresa = "../../empresas/".$_GET['empresa']."/";
$url_css = $url_empresa."style.css";
$url_less = $url_empresa."style.less";

$url_logo_ico = file_exists($url_empresa."logo.ico")?$url_empresa."logo.png":"../img/logo.ico";
$url_logo_img = file_exists($url_empresa."logo.png")?$url_empresa."logo.png":"../img/logo.png";

$nombre_empresa =  ucwords(strtolower($_GET['empresa']),'_');
$nombre_empresa = str_replace("_"," ",$nombre_empresa);

//Compilando la hoja de estilos
require_once "../connect/conexion.php";
$empresa_bd = $_GET['empresa'];
$conexion = conexion(false,$empresa_bd,false);
require_once "../../css/compilaLess.php";
compilaLess($url_css,$url_less);
//************************************


function srcLogo(){
	if (file_exists("logo.png")){
		$path = "logo.png";
	}else if (file_exists("logo.jpg")){
		$path = "logo.jpg";
	}else{
		$path = "../../img/logo.png";
	}
	 return $path;
}
?>
<!DOCTYPE html>
<html lang="es" ><head>
<title>Agenda OnLine</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel='shortcut icon' href='<?php echo $url_logo_ico?>' >
<link rel="stylesheet"  type="text/css" href="../../css/metro.css">
<link rel="stylesheet"  type="text/css" href="../../fontello/css/iconos.css">
<link rel="stylesheet"  type="text/css" href="<?php echo $url_empresa?>style.css">

<script  type="text/javascript" src="../../js/start.js"></script>

    <title>Recuperar contraseña</title>
</head><body>
	<div class="login-form">
		<img id="logo" src="../../img/logo.png" width=64>
		<form   id="frmRestablecer" action="validaremail.php?empresa=<?php echo $_GET['empresa']?>" method="GET">
			<h1 class="heading"> Restaurar contraseña </h1>	
			<div class="iconClass-container icon-left">
				<input type="email" class= "email" id="login" name="login" placeholder=" Email asociado a la cuenta" value="<?php if(isset($email_demo)){echo $email_demo;}?>" require>
				<span class="iconClass-inside icon-mail-1"></span>
			</div>
            <div class="submit">
				<button type="submit" class="btn-success">Enviar</button>
                <button type="button" id= 'btnCancel'  class="btn-danger inicio">Cancelar</button>
            </div>
        </form>
    </div>
</body></html>