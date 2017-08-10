<?php 
session_start ();

$url_empresa = "../empresas/".$_GET['empresa']."/";
$url_css = $url_empresa."style.css";
$url_less = $url_empresa."style.less";

$url_logo_ico = file_exists($url_empresa."logo.ico")?$url_empresa."logo.png":"../img/logo.ico";
$url_logo_img = file_exists($url_empresa."logo.png")?$url_empresa."logo.png":"../img/logo.png";

$nombre_empresa =  ucwords(strtolower($_GET['empresa']),'_');
$nombre_empresa = str_replace("_"," ",$nombre_empresa);
$nombre_empresa = str_replace("/","",$nombre_empresa);

require 'libs/tools.php' ;

if(isset($_COOKIE["id_user"])&&!isset($_GET["closeSession"])){
	header ("location:../php/validar.php");
	exit;
}else{
	 if(isset($_GET["closeSession"])||isset($_GET['err'])){
		destroySession();
		session_start ();
	}
}

$_SESSION['bd'] =  $_GET['empresa'] ;

require_once "connect/conn.controller.php";

//Compilando la hoja de estilos
require_once "../css/compilaLess.php";
compilaLess($url_css,$url_less);
//************************************

function srcLogo(){
	$url = "../../empresas/".$_GET['empresa']."/logo.png" ;
	if (file_exists($url)){
		$path = $url;
	}else{
		$path =  "../../img/logo.png";
	}
	return $url;
}
?>
<!DOCTYPE html>
<html lang="es" ><head>
<title>agenda OnLine</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel='shortcut icon' href='<?php echo $url_logo_ico?>' >
<link rel="stylesheet"  type="text/css" href="../../css/metro.css">
<link rel="stylesheet"  type="text/css" href="../../fontello/css/iconos.css">
<link rel="stylesheet"  type="text/css" href="style.css">
<script  type="text/javascript" src="../../js/start.js" async defer></script>
</head><body data-empresa="<?php echo $nombre_empresa?>">
	<div class="login-form login-principal">
		<a href= "<?php echo CONFIG['Web']; ?>">
			<img id="logo" src="<?php echo srcLogo()?>"  width=64>
		</a>
		<h1 class="heading">agenda <?php if(isset($nombre_empresa)){echo $nombre_empresa;}?></span></h1>

		<form id="loginUsuario" method="post" action="../../php/validar.php"  defaultbutton="Entrar"
			data-role="popover" data-popover-position="top" data-popover-text="Error en nombre o la contraseña."
			data-popover-background="bg-red" data-popover-color="fg-white">
			<input type="hidden" id="empresa" name="empresa" value="<?php  echo $_GET['empresa']?>">
			<input type="hidden"  id="ancho" name="ancho">
			<input type="hidden"  id="alto" name="alto">
			<div class="iconClass-container icon-left">
				<input type="email" class= "email" id="login" name="login" placeholder="Introduzca su Email" value="<?php if(isset($email_demo)){echo $email_demo;}?>" require>
				<span class="iconClass-inside icon-mail-1"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="password" id="fakePass" name="fakePass" placeholder="Introduzca su contraseña" value="<?php if(isset($pass_demo)){echo $pass_demo;}?>" require>
				<input type="hidden" id="pass" name="pass" value="<?php if(isset($pass_sha1_demo)){echo $pass_sha1_demo;}?>">
				<span class="iconClass-inside icon-eye"></span>
			</div>
			<div id="chkNoCerrarSesion">
				<input type="checkbox" id="recordar"  name="recordar" value="1" >
				<span class="info">No cerrar sesión.</span>
				<a class="politicLink">Politica de cookies</a>
			</div>
			<button type="button" class="btn-success btnLoad"  id="btnLogin" value="Entrar" default>Entrar</button>
		</form>
		<div>
		<div id="frameSocialMedia">
			<div id="tileSocialMedia">
				<span id="tile">O connecta con ... </span>
				<hr>
			</div>
			<button class = "facebook  image-button icon-facebook"  id='fb-facebookLogin'></button>
			<button class = "google  image-button icon-gplus "  id='idGoogle'></button>
		</div>
		<div class="login-help">
			<p>
				¿Olvidaste la contraseña?
				<a href="../../php/recuperarPass/forgetPass.php?empresa=<?php echo$_GET['empresa']?>">Pulsa aquí</a>.
			</p>
			<p>
				<a href="nuevo.php">Crear nuevo usuario.</a>.
			</p>
		</div>
	</div>
	<section class="login about">
		<center>
			<p class="about-author">
				&copy; 2016 <a href="https://www.agendaonline.es" target="_blank">agendaOnLine v5.1</a>
				Creado por Néstor Pons
				<a href="contacto.html" target="_blank">Contacto</a>
			</p>
		</center>
				<div class="fb-like" data-share="true"  data-width="450" data-show-faces="true"></div>
		<div class="g-plusone" data-href="https://plus.google.com/107403979941433242739/posts"></div>
			</div>
	</section>

<script src="https://apis.google.com/js/platform.js" async defer>{lang: 'es'}</script>
</body></html>
