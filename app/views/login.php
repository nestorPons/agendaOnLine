<?php 
include URL_TEMPLATES . '/header.php' ;
$url_form = 'http://' . $_SERVER['SERVER_NAME'] .'/'. NAME_DB .'/'. 'validar';
?>
<body data-empresa="<?= $nombre_empresa?>" background="<?=  backgroundImage() ?>" >

	<div class="login-form login-principal">
		<a href= "<?=CONFIG['Web']??''?>">
			<img id="logo" src="<?= srcLogo()?>"  width=64>
		</a>
		<h1 class="heading">agenda <?= isset($nombre_empresa)?$nombre_empresa : '' ?></span></h1>

		<form id="loginUsuario" method="post" action='<?= $url_form ?>' defaultbutton="Entrar"
			data-role="popover" data-popover-position="top" data-popover-text="Error en nombre o la contraseña."
			data-popover-background="bg-red" data-popover-color="fg-white">
			<input type="hidden"  id="ancho" name="ancho">
			<input type="hidden"  id="alto" name="alto">
			<div class="iconClass-container icon-left">
				<input type="email" class= "email" id="login" name="login" placeholder="Introduzca su Email" value="<?php if(isset($email_demo)){echo $email_demo;}?>" require>
				<span class="iconClass-inside icon-mail-1"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="password" id="fakePass" name="fakePass" placeholder="Introduzca su contraseña" value="<?php if(isset($pass_demo)){echo $pass_demo;}?>" require>
				<input type="hidden" id="pass" name="pass" value="<?= isset($pass_sha1_demo) ? $pass_sha1_demo : '' ?>">
				<span class="iconClass-inside icon-eye"></span>
			</div>
			<div id="chkNoCerrarSesion">
				<input type="checkbox" id="recordar"  name="recordar" value="1" >
				<span class="info">No cerrar sesión.</span>
				<a class="politicLink" href = "" >Politica de cookies</a>
			</div>
			<button class="btn-success btnLoad"  id="btnLogin" value="Entrar" default>Entrar</button>
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
				<a href="../../php/recuperarPass/forgetPass.php?empresa=<?= NAME_DB?>">Pulsa aquí</a>.
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
</body>
</html>