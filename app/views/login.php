<?php 
	include URL_TEMPLATES . '/header.php' ;
	$url_validate= URL_PROTOCOL .  $_SERVER['SERVER_NAME'] .'/'. NAME_EMPRESA .'/'. 'validar';

	?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=NAME_EMPRESA?>" class="<?=CLASS_BACKGROUND?>" >
		<div id="login" class="login login-form ">
			<section id="secLogin">
				<a href= "<?=CONFIG['web']??''?>" >
					<img id="logo" src="/<?=URL_LOGO?>" alt="logo image"/>
				</a>
				<h1 class="heading">Agenda <?= \core\Tools::normalizeShow(NAME_EMPRESA) ?></span></h1>
				<hr>
				<form id="loginUsuario" method="post" action='<?= $url_validate ?>' defaultbutton="Entrar"
					data-role="popover" data-popover-position="top" data-popover-text="Error en nombre o la contraseña."
					data-popover-background="bg-red" data-popover-color="fg-white">
					<input type="hidden"  id="ancho" name="ancho">
					<div class="iconClass-container icon-left">
						<input type="email" class= "email" id="login" name="login" placeholder="Introduzca su Email" 
						value="<?php if(isset($email_demo)){echo $email_demo;}?>" require>
						<span class="iconClass-inside icon-mail-1"></span>
					</div>
					<div class="iconClass-container icon-left">
						<input type="password" id="fakePass" placeholder="Introduzca su contraseña" require>
						<input type="hidden" id="pass" name="pass">
						<span class="iconClass-inside icon-eye"></span>
					</div>
					<div id="chkNoCerrarSesion">
						<input type="checkbox" id="recordar"  name="recordar" value="1" >
						<span class="info">No cerrar sesión.</span>
						<a class="politicLink" href = "" >Politica de cookies</a>
					</div>

					<button class="btn-success btnLoad"  id="btnLogin" value="Entrar" default>Entrar</button>

				</form>
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
							<a id="forgotPass">Pulsa aquí</a>.
						</p>
						<p>
							<a id="aNewUser">Crear nuevo usuario.</a>.
						</p>
					</div>
			</section>
		</div>
		<footer class="login about">
			<p class="about-author">
				&copy; 2016 <a href="https://www.agendaonline.es" target="_blank">agendaOnLine v2.1</a>
				Creado por Néstor Pons
				<a href="contacto.html" target="_blank">Contacto</a>
			</p>			
		</footer>
	</body>
</html>