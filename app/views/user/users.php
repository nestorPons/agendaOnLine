<?php include URL_TEMPLATES . '/header.php' ?>
	<script>
		document.festivos = <?=json_encode (FESTIVOS)?>;
		document.minTime = <?=json_encode(CONFIG['minTime'])?>;
		document.idUser = <?=$_SESSION['id_usuario']?>;
		document.margenDias  = <?=MARGIN_DAYS?> ; 
	</script>
    <title>Menu agenda On line zona usuarios</title>
</head>
<body id="user" user="user" iduser = <?=$_SESSION['id_usuario']?>>
<?php require_once URL_MENUS . 'users.php'?>
<div id="login" class="login">	
	<div class="tile-container" id="contenedorMenuPrincipal">
		<section id="crearCita" name="tile" class="tile " data-role="tile">
			<div class="tile-content iconic">
				<div class="mensaje">
					<span class="icon icon-edit"></span>
					<span class="tile-label">Coja su cita</span>
				</div>
				<div class="contenido">
					<?php include URL_CONTROLLERS . 'crearCita.php'?>
				</div>
			</div>
		</section>
		<section id="config"  name="tile" class="tile tile-secon" data-role="tile">
			<div class="tile-content iconic">
				<div class="mensaje">
					<span class="icon icon-user-1"></span>
					<span class="tile-label">Mis datos</span>
				</div> 	
				<div class="contenido">
					<?php// include URL_VIEWS_USER . 'user.php'?>
				</div>
			</div>
		</section>
		<section id="historial" class="tile-wide "  name="tile" data-role="tile">
			<div class="tile-content iconic">
				<div class="mensaje">
					<h3><span id='mensajeHistorial'></span></h3>
					<span class="icon icon-calendar"></span>
					<span id="lblHis" class="tile-badge"></span>
					<span class="tile-label">Citas</span>
				</div>
				<div class="contenido">
					<h1 class="margin0">Historial</h1>
						<br>
						<?php include URL_VIEWS_USER . 'historial.php'?>
					<input type="button" class="btn-danger cancelar" name="cancelar" value="Cerrar"> 
				</div>
			</div>
		</section>
		<section id="eliminar" class="tile-small"  name="tile" data-role="tile">
			<div class="tile-content">
				<span  class="icon icon-user-times" data-role="hint" data-hint-background="bg-red" data-hint-color="fg-white" 
					data-hint="Eliminar|Pusar para eliminar el usuario">
				</span>
			</div>
		</section>
	</div>
</div>
	<section class="about">
		<div id="fb-root"></div>
		<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" 
			data-layout="standard" data-action="recommend" data-show-faces="true" data-share="true"></div>
	</section>
	<div id="dialogs" class="popup-overlay"></div>
</body></html>