<div  id= "navbar" class="app-bar" data-role="appbar">
	<a href="/" class="app-bar-element branding">
		<img id="logo" src="/img/logo.png" width="64">
	</a>
	<span class="app-bar-divider"></span>
	<ul class="app-bar-menu ">
		<li><a  href=""><span class="icon-home">Home</span></a></li>		
		<li><a  href="<?= URL_EMPRESAS ?>"><span class="icon-user"  id='lblUser'><?=$User->nombre?></span></a><li>
	</ul>
	<ul class="app-bar-menu place-right" data-flexdirection="reverse">
		<li><span class="app-bar-divider"></li>
		<li><div  class="responsive " id="reloj"></div></li>
		<li>
			<a href="/<?=CODE_EMPRESA?>?destroy=true">
				<span id="mnuUserSalirSession" class="icon-link-ext">Cerrar sesión</span>
			</a>
		</li>
	</ul>
</div>