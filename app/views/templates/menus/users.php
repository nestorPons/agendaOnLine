<div id="mnuDatosPersonales" data-role="charm" data-position="right">
	<h1>Datos personales</h1>
	<div class="">
		<?php
		include URL_VIEW_USER . 'datos.php'; 
		?>
	</div>
</div>
<nav  id= "navbar" class="app-bar" data-role="appbar">
	<a href= "<?=CONFIG['web']??''?>"  target="_blank">
		<img id="logo" src="/<?=URL_LOGO?>" alt="logo image"/>
	</a>
	<span class="app-bar-divider"></span>
	<ul class="app-bar-menu ">
		<li><a  href="<?= URL_EMPRESAS ?>"><span id='lblUser'>Bienvenid@ <?=$User->nombre?></span></a><li>
	</ul>
	<ul class="app-bar-menu place-right" data-flexdirection="reverse">
		<li><span class="lnr-home"></span></li>		
		<li>
			<span id="btnConfig" class="lnr-user"></span>
		</li>
		<li>
			<a href="/<?=CODE_EMPRESA?>?destroy=true">
				<span id="mnuUserSalirSession" class="lnr-power-switch"></span>
			</a>
		</li>
	</ul>
</nav>
