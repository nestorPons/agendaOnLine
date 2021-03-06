<div id="charms">
	<div id="mnuDatosPersonales" class="charm" >
		<div class="">
			<?php
			include URL_VIEWS_USER . 'datos.php'; 
			?>
		</div>
	</div>
	<div id="mnuConfig" class="charm">
		<div class="contenedor">
			<div id="authEmail" class="checkbox">
				<div class="switch">
					<input type="checkbox" name="switch" class="switch-checkbox" value="authEmail" <?= $User->authEmail()?"checked":""?>>
					
					<label class="switch-label" for="myswitch">
						<span class="switch-inner"></span>
						<span class="switch-switch"></span>
					</label>
				</div>
				<span for="authEmail">Recibir recordatorio correo electronico.</span>
			</div>
		</div>
	</div>
</div>
<nav  id= "navbar" class="app-bar" data-role="appbar">
	<a href= "<?=CONFIG['web']??''?>"  target="_blank">
		<img id="logo" src="./<?=URL_LOGO_48?>" alt="logo image"/>
	</a>
	<span class="app-bar-divider"></span>
	<?php if(!$Device->isMobile()){ ?>
		<ul class="app-bar-menu ">
			<li class="noHover" id='lblUser'>
				<span>Bienvenid@ </span>
				<span id="lblNombre"><?=$User->nombre?></span><li>
		</ul>
		<?php 
	}?>
	<ul class="app-bar-menu place-right" data-flexdirection="reverse">
		<li id="goHome" title="Inicio"><span class="lnr-home"></span></li>		
		<li id="btnDatos"  data-menu="mnuDatosPersonales" title="Datos">
			<span class="lnr-user"></span>
		</li>
		<li id="btnConfig"  data-menu="mnuConfig" title="Configuración">
			<span class="lnr-cog"></span>
		</li>
		<li id="btnExit" title="Salir" >
			<i class="lnr-power-switch"></i>
		</li>
	</ul>
</nav>
