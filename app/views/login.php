<?php 
	include URL_TEMPLATES . '/header.php' ;

	$url_validate= '/'. CODE_EMPRESA .'/'. 'validar';
?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=CODE_EMPRESA?>" class="<?=CLASS_BACKGROUND?>" >
		<div id="login" class="login login-form ">
			<section id="secLogin">
				<a href= "<?=CONFIG['web']??''?>"  target="_blank">
					<img id="logo" src="/<?=URL_LOGO?>" alt="logo image"/>
				</a>
				<h1 class="heading">Agenda <?=CODE_EMPRESA?></span></h1>
				<hr>
				<form id="loginUsuario" method="POST" action='<?= $url_validate ?>' defaultbutton="Entrar"
					data-role="popover" data-popover-position="top" data-popover-text="Error en nombre o la contraseña."
					data-popover-background="bg-red" data-popover-color="fg-white">
					<input type="hidden"  id="ancho" name="ancho">
					<div class="iconClass-container icon-left">
						<input type="email" class= "email" id="login" name="login" placeholder="Introduzca su Email" 
						value="<?php if(isset($demo_email)){echo $demo_email;}?>" require>
						<i class="iconClass-inside icon-mail-1"></i>
					</div>
					<div class="iconClass-container icon-left">
						<input type="password" id="fakePass" placeholder="Introduzca su contraseña" value="<?php if(isset($demo_pass)){echo $demo_pass;}?>" require>
						<input type="hidden" id="pass" name="pass">
						<i class="iconClass-inside icon-eye"></i>
					</div>
					<div id="chkNoCerrarSesion">
						<input type="checkbox" id="recordar"  name="recordar" value="1" >
						<span class="info">Iniciar sesión con un pin.</span>
					</div>

					<button class="btn-success btnLoad"  id="btnLogin" value="Entrar" default>Entrar</button>

				</form>
<!-- a falta de implementar los botones de facebook y g+ 
					<div id="frameSocialMedia">
						<div id="tileSocialMedia">
						</div>
						<button class = "facebook  image-button icon-facebook"  id='fb-facebookLogin'> conectar...</button>
						<button class = "google  image-button icon-gplus "  id='idGoogle'> conectar...</button>
					</div>
-->
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
				&copy; 2016 <a href="/.." target="_blank">reservaTuCita v6.1</a>
				Creado por Néstor Pons
				<a href="contacto.html" target="_blank">Contacto</a>
			</p>			
		</footer>
		
<!--//BLOQUE COOKIES-->
<div id="barraaceptacion">
    <div class="inner">
        Solicitamos su permiso para obtener datos estadísticos de su navegación en esta web, en cumplimiento del Real 
        Decreto-ley 13/2012. Si continúa navegando consideramos que acepta el uso de cookies.
        <a href="javascript:void(0);" class="ok" onclick="PonerCookie();"><b>OK</b></a> | 
		<a href="politicCookies.php?empresa=<?=CODE_EMPRESA?>" target="_blank" class="info">Más información</a>
    </div>
</div>
<!--//FIN BLOQUE COOKIES-->
	</body>
</html>