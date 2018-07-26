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
	<!--
			<div  id="authCal" class="checkbox">
				<div class="switch">
				
				
				<input type="checkbox" name="switch" class="switch-checkbox" value="authCal" <?= $User->authCal()?"checked":""?>>
				
				<label class="switch-label" for="myswitch">
					<span class="switch-inner"></span>
					<span class="switch-switch"></span>
				</label>
				</div>
				<span for="authCal">Recibir recordatorio en mi calendario Google.</span>
			</div>
	-->
		</div>
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
		<li id="btnDatos"  data-menu="mnuDatosPersonales">
			<span class="lnr-user"></span>
		</li>
		<li id="btnConfig" data-menu="mnuConfig">
			<span class="lnr-cog"></span>
		</li>
		<li id="mnuUserSalirSession" >
			<a href="/<?=CODE_EMPRESA?>?destroy=true"  class="lnr-power-switch"></a>
		</li>
	</ul>
</nav>
