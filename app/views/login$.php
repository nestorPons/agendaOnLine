<?php 
	include URL_VIEWS . 'login/header.php' ;
?>
	<title>Agenda Online zona login</title>
	</head>
	<body data-empresa="<?=$Empresa->code()?>" class="<?=CLASS_BACKGROUND?>" >
		<main id="login">
			<div class="login login-form ">
				<section id="secLogin">
					<a href= "<?=CONFIG['web']??''?>"  target="_blank">
						<img id="logo" src="/<?=URL_LOGO?>" alt="logo image"/>
					</a>
					<h1 class="heading">Agenda <?=NAME_EMPRESA?></span></h1>
					<hr>
					<form id="loginUsuario" defaultbutton="Entrar"
						data-role="popover" data-popover-position="top" data-popover-text="Error en nombre o la contraseña."
						data-popover-background="bg-red" data-popover-color="fg-white">
						<div class="iconClass-container icon-left">
							<input type="email" class= "email" id="login" name="login" placeholder="Introduzca su Email" 
							value="<?php if(isset($demo_email)){echo $demo_email;}?>" require>
							<i class="iconClass-inside icon-mail-1"></i>
						</div>
						<div class="iconClass-container icon-left">
							<input type="password" id="pass" placeholder="Introduzca su contraseña" value="<?php if(isset($demo_pass)){echo $demo_pass;}?>" require>
							<i class="iconClass-inside icon-eye"></i>
						</div>
						<div id="chkNoCerrarSesion">
							<input type="checkbox" id="recordar"  name="recordar" value="1" >
							<span class="info">Iniciar sesión con un pin.</span>
						</div>

						<button class="btn-success btnLoad"  id="btnLogin" value="Entrar"  disabled default>Entrar</button>

					</form>
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
			<?php include URL_TEMPLATES . 'login_footer.php'?>
			
			<!--//BLOQUE COOKIES-->
			<div id="barraaceptacion">
				<div class="inner">
					Solicitamos su permiso para obtener datos estadísticos de su navegación en esta web, en cumplimiento del Real 
					Decreto-ley 13/2012. Si continúa navegando consideramos que acepta el uso de cookies.
					<a href="javascript:void(0);" id="btnbarraaceptacion" class="ok"><b>ACEPTAR</b></a> | 
					<a href="/sources/politicCookies.php?empresa=<?=$Empresa->code()?>" target="_blank" class="info">Más información</a>
				</div>
			</div>
	<!--//FIN BLOQUE COOKIES-->

		</main>
	</body>
</html>