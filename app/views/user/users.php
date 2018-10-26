
<header><?php require_once URL_MENUS . 'users.php'?></header>
<main id="users" user="user" iduser = <?=$_SESSION['id_usuario']?> class="no-seleccionable">
		<div class="tile-container" id="contenedorMenuPrincipal">
			<section id="crearCita" name="tile" class="tile " data-role="tile">
				<div	 class="tile-content iconic">
					<div class="mensaje">
						<span class="icon icon-edit"></span>
						<span class="tile-label">Coja su cita</span>
					</div>
					<div class="contenido">
						<?php include URL_CONTROLLERS . 'crearCita.php'?>
					</div>
				</div>
			</section>
			<section id="historial" class="tile<?php if(!$Device->isMobile())echo"-wide" ?> "  name="tile" data-role="tile">
				<div class="tile-content iconic">
					<div class="mensaje">
						<h3><span id='mensajeHistorial'></span></h3>
						<span class="icon icon-calendar"></span>
						<span id="lblHis" class="tile-badge"></span>
						<span class="tile-label">Reservas</span>
					</div>
					<div class="contenido">
						<h1 class="margin0">Citas pendientes</h1>
							<?php include URL_VIEWS_USER . 'historial.php'?><br>
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
	<div id="dialogs" class="popup-overlay"></div>
</main>
<footer class="about">
	<div id="fb-root"></div>
	<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" 
		data-layout="standard" data-action="recommend" data-show-faces="true" data-share="true"></div>
</footer>
<script src="/js/min/users.js"></script>