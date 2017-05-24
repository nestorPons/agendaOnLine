<?php 
	if (file_exists("../arch/logo.png")){
		$path = "../arch/logo.png";
	}else if (file_exists("../arch/logo.jpg")){
		$path = "../arch/logo.jpg";
	}else{
		$path = "../../img/logo.png";
	}
	 
?>
<div  id= "navbar" class="app-bar" data-role="appbar">
	<a href="<?php echo CONFIG['Web']??"www.agendaOnline.es";?>" class="app-bar-element branding">
		<img id="logo" src="<?php echo $path?>" width="64">
	</a>
	<span class="app-bar-divider"></span>
	<ul class="app-bar-menu ">
		<li><a  href="index.php"><span class="icon-home"> Home</span></a></li>		
		<li><a  href="../php/users/usuario/index.php"><span class="icon-user"  id='lblUser'></span></a><li>
	</ul>
	<ul class="app-bar-menu place-right" data-flexdirection="reverse">
		<li><span class="app-bar-divider"></li>
		<li><div  class="responsive " id="reloj"></div></li>
		<li>
			<a href="../index.php?closeSession=1">
				<span id="mnuUserSalirSession" class="icon-link-ext ">Cerrar sesión</span>
			</a>
		</li>
	</ul>
</div>