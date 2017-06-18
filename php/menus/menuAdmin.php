<div id="mnuContacto" data-role="charm" data-position="right">
	<h1>Contacto</h1>
	<div class="">
		<form id="frmContact">
			<h4>Formulario de contacto ....</h4>
			<div class="iconClass-container icon-left">
				<input type="text" name="nombre" placeholder="Nombre" value='<?php echo CONFIG['NomUser']?>'>
				<span class="icon-user iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="text" name="empresa" placeholder="Empresa" value='<?php echo CONFIG['Nombre']?>'>
				<span class="icon-shop  iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="email" name="email" placeholder="Email de contacto" value='<?php echo CONFIG['Email']?>'>
				<span class="icon-mail iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="tel" name="telefono" placeholder="Telefono" value='<?php echo CONFIG['Tel']?>'>
				<span class="icon-phone iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<textarea name='mensaje' class="txt" rows=5 placeholder='Dejenos su mensaje'  data-autoresize ></textarea>		
			</div>
			<button type="submit" class="btn-success btnLoad"  data-value="Enviar">Enviar</button>
		</form>
	</div>

	<hr>
	<h3>o puede contactarnos por ...</h3> 
	<a href="https://www.agendaOnLine.es" >www.AgendaOnLine.es</a>
	<a href="mailto:nestorpons@gmail.com?Subject=Contacto AgendaOnLine" 	
		target="_top">
		Nestorpons@gmail.com
	</a>
</div>

<nav  id= "navbar" class="app-bar" data-role="appbar" >
	<img id= "btnContacto" src="../../img/logo.png" class="app-bar-element branding">
	<span class="app-bar-divider"></span>
	
	<ul class="app-bar-menu">
			
			<li>
				<a id="menu1" name='menu[]' class="app-bar-element" data-capa="crearCita">
					<span class="icon-edit"></span>
					<span>Cita</span>
				</a>
			</li>
			<li>
				<a id="menu0" name='menu[]' class="app-bar-element" data-capa="main">
					<span class="icon-wallet"></span>
					<span >Agendas</span>
				</a>
			</li>
			<li>
				<a id="menu2" name='menu[]' class="app-bar-element" data-capa="usuarios">
					<span class="icon-users"></span>
					<span>Clientes</span>
				</a>
			</li>
			<li>
				<a class="dropdown-toggle">
					<span class="icon-th-list"></span>
					<span >Servicios</span>
				</a>
				<ul class="d-menu" data-role="dropdown">
					<li>
						<a id="menu3" name='menu[]' data-capa="servicios" >Servicios</a>
					</li>
					<li><a id="menu4" name='menu[]' data-capa="familias">Familias</a></li>
				</ul>
			</li>
			<li>
				<a id="menu8"  class="dropdown-toggle">
					<span class="icon-cog"></span>
					<span>Config</span>
				</a>
				<ul class="d-menu" data-role="dropdown">
					<li><a name='menu[]' data-capa="general">Mis datos</a></li>
					<li><a name='menu[]' data-capa="config"	>Configuración</a></li>
					<li><a name='menu[]' data-capa="horarios" >Horarios</a></li>
					<li><a name='menu[]' data-capa="festivos" >Festivos</a></li>
					<li><a name='menu[]' data-capa="agendas">Agendas</a></li>	
				</ul>
			</li>
			<?php
			if(CONFIG['Plan']>1){
				?>
				<li>
					<a id="menu5"  name='menu[]'  data-capa="notas">
						<i id="icon-info-circled"></i>
						Notas
					</a>
				</li>
				<li>
					<a id="menu9" name='menu[]'   data-capa="historia">Historia</a>
				 </li>
				 <?php 
			}?>

			
	</ul>
<!--menu herramientas-->
	<ul class="herramientas app-bar-menu place-right no-flexible" data-flexdirection="reverse">
		<span class="app-bar-divider"></span>
		<li id="btnExit" class="no-flexible place-right">
			<a href="../../empresas/<?php echo $_SESSION['bd']?>?closeSession=1">
				<span id="mnuUserSalirSession" class="icon-logout"></span>
			</a>
		</li>
		 <div id="btnSearch" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon-search"></span>
			<span  class="menulbl">Buscar</span>
		</div>
		<li id="btnOptions" class="disabled">
			<a class="dropdown-toggle no-flexible place-right  ">
				<span class="icon-cog"></span>
				<span  class="menulbl">Opciones</span>
			</a>
			<ul class="d-menu" data-role="dropdown">
				<li>
					<input type="checkbox" id="chckOpUsersDel">
					<label for = "chckOpUsersDel" >	Mostrar eliminados.</label>
				</li>

			</ul>
		</li>

		 <div id="btnReset" class="app-bar-element no-flexible place-right ">
			<span  class="icon-undo"></span>
			<span  class="menulbl">Refrescar</span>
		</div>
		 <div id="btnDel" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon-trash"></span>
			<span  class="menulbl">Eliminar</span>
		</div>
		 <div id="btnAdd" class="app-bar-element no-flexible place-right disabled" data-value=0>
			<span  class="icon-plus-circled" ></span>
			<span  class="menulbl">Nuevo</span>
		</div>
		 <div id="btnSave" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon-floppy" ></span>
			<span class="icon-load animate-spin"></span>
			<span class="menulbl">Guardar</span>
		</div>
		 <div id="btnEdit" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon-edit" ></span>
			<span class="icon-load animate-spin"></span>
			<span class="menulbl">Editar</span>
		</div>
		<div id="btnShow" class="app-bar-element no-flexible place-right" >
				<span class="off icon-list <?php echo CONFIG['ShowRow']==1?"hidden":""?>"></span>
				<span class="on icon-list-nested <?php echo CONFIG['ShowRow']==1?"":"hidden"?>"></span>
				<span class="menulbl"><?php echo CONFIG['ShowRow']==1?"Ocultar":"Mostrar"?></span>
		</div>
	</ul>
	<div id="conTxtBuscar" class=" place-right"> 
		<input type="search" name="txtName" id="txtBuscar">
	</div>

</nav>
