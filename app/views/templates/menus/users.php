<div id="mnuDatosPersonales" data-role="charm" data-position="right">
	<div class="">
		<?php
		include URL_VIEWS_USER . 'datos.php'; 
		?>
	</div>
</div>
<nav  id= "navbar" class="app-bar" data-role="appbar">
	<a href= "<?=CONFIG['web']??''?>"  target="_blank">
		<img id="logo" src="/<?=URL_LOGO?>" alt="logo image"/>
	</a>
	<span class="app-bar-divider"></span>
	<?php if(!$Device->isMovile){ ?>
		<ul class="app-bar-menu ">
			<li class="noHover" id='lblUser'>
				<span>Bienvenid@ </span>
				<span id="lblNombre"><?=$User->nombre?></span><li>
		</ul>
		<?php 
	}?>
	<ul class="app-bar-menu place-right" data-flexdirection="reverse">
		<li><span class="lnr-home"></span></li>		
		<li id="btnConfig">
			<span class="lnr-user"></span>
		</li>
		<li id="mnuUserSalirSession">
			<a href="/<?=CODE_EMPRESA?>?destroy=true"  class="lnr-power-switch"></a>
		</li>
	</ul>
</nav>
