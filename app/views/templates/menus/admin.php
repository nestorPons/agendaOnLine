<div id="mnuContacto" data-role="charm" data-position="right">
	<h1>Buzon de sugerencias</h1>
	<div class="">
		<form id="frmContact">
			<h4>Formulario de contacto ....</h4>
			<div class="iconClass-container icon-left">
				<input type="text" name="nombre" placeholder="nombre" value='<?=CONFIG['nombre_usuario']?>'>
				<span class="icon-user iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="text" name="empresa" placeholder="Empresa" value='<?=CONFIG['nombre_empresa']?>'>
				<span class="icon-shop  iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="email" name="email" placeholder="Email de contacto" value='<?=CONFIG['email']?>'>
				<span class="icon-mail iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<input type="tel" name="telefono" placeholder="Telefono" value='<?=CONFIG['tel']?>'>
				<span class="icon-phone iconClass-inside"></span>
			</div>
			<div class="iconClass-container icon-left">
				<textarea name='mensaje' class="txt" rows=5 placeholder='Dejenos su mensaje'  data-autoresize ></textarea>		
			</div>
			<button type="submit" class="btn-success btnLoad"  data-value="Enviar">Enviar</button>
		</form>
	</div>

	<hr>
	<h3>o puede contactarnos en ...</h3> 
	<a href="<?=ADMIN_WEB?>" >www.ReservaTuCita.es</a>
	<a href="mailto:<?=ADMIN_EMAIL?>?Subject=Contacto agendaOnLine" 	
		target="_top">
		<?=ADMIN_EMAIL?>
	</a>
</div>

<nav  id= "navbar" class="app-bar" data-role="appbar" >
	
	<ul class="app-bar-menu">
			<li>
				<a id="menu1" name='menu[]' class="app-bar-element " data-capa="crearCita">
					<span class="icon-edit"></span>
					<span class="caption" >Cita</span>
				</a>
			</li>
			<li>
				<a id="menu0" name='menu[]' class="app-bar-element selected" data-capa="main">
					<span class="icon-wallet"></span>		
					<span class="caption ">agendas</span>				
				</a>
			</li>
			<li>
				<a id="menu5"  name='menu[]'  data-capa="notas">
					<span class="icon-pencil-1"></span>
					<span class="caption">Notas</span>
				</a>
			</li>
			<li>
				<a id="menu2" name='menu[]' class="app-bar-element" data-capa="usuarios">
					<span class="icon-users"></span>
					<span class="caption">Clientes</span>
				</a>
			</li>
			<li>
				<a class="dropdown-toggle" data-capa="mnuServicios">
					<span class="icon-th-list"></span>
					<span class="caption">Servicios</span>
				</a>
				<ul class="d-menu" data-role="dropdown">
					<li>
						<a id="menu3" name='menu[]' data-capa="servicios" >Servicios</a>
					</li>
					<li>
						<a id="menu4" name='menu[]' data-capa="familias" >Familias</a>
					</li>
				</ul>
			</li>

			<li>
				<a id="menu9"  name='menu[]'  data-capa="history">
					<span class="icon-clock"></span>
					<span class="caption">Historial</span>
				</a>
			</li>
			<li>
				<a id="menu8"  class="dropdown-toggle">
					<span class="icon-cog"></span>
					<span class="caption">Config</span>
				</a>
				<ul class="d-menu" data-role="dropdown">
					<li><a name='menu[]' data-capa="general">Mis datos</a></li>
					<li><a name='menu[]' data-capa="config"	>Configuración</a></li>
					<li><a name='menu[]' data-capa="horarios" >horarios</a></li>
					<li><a name='menu[]' data-capa="festivos" >Festivos</a></li>
					<li><a name='menu[]' data-capa="agendas">agendas</a></li>	
					<li><a name='menu[]' data-capa="estilos">Estilos</a></li>	
				</ul>
			</li>

			
	</ul>
	<ul class="app-bar-menu place-right no-flexible" data-flexdirection="reverse">
		<li id="btnExit" class="app-bar-element no-flexible place-right">
			<a href="/<?=CODE_EMPRESA?>/logout">
			<span id="mnuUserSalirSession" class="icon icon-logout"></span>
		</a>
	</li>
	<li id= "btnContacto" class="app-bar-element no-flexible place-right">
		<i  class=" icon-mail"></i>
	</li>
</ul>
<!--menu herramientas-->

		<ul class="herramientas app-bar-menu place-right no-flexible" data-flexdirection="reverse">
		 <div id="btnSearch" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon icon-search"></span>
			<span  class="menulbl">Buscar</span>
		</div>
		<div id="btnOptions" class="app-bar-element no-flexible place-right disabled">
			<a class="dropdown-toggle no-flexible place-right  ">
				<span class="icon icon-cog"></span>
				<span  class="menulbl">Opciones</span>
			</a>
			<ul class="d-menu" data-role="dropdown">
				<li id=rowsHiddens class=disabled>
					<input type="checkbox" id="chckOpUsersDel">
					<label for = "chckOpUsersDel" >	Mostrar eliminados.</label>
				</li>
				<li id=showByTime class=disabled>
					<label><input type="radio" value=1 checked>Último dia</label><br>
					<label><input type="radio" value=7 >Última semana</label><br>
					<label><input type="radio" value=30 >Último mes</label><br>
				</li>

			</ul>
		</div>

		 <div id="btnReset" class="app-bar-element no-flexible place-right">
			<span  class="icon icon-undo"></span>
			<span  class="menulbl">Refrescar</span>
		</div>
		 <div id="btnDel" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon icon-trash"></span>
			<span  class="menulbl">Eliminar</span>
		</div>
		 <div id="btnAdd" class="app-bar-element no-flexible place-right disabled" data-value=0>
			<span  class="icon icon-plus-circled" ></span>
			<span  class="menulbl">Nuevo</span>
		</div>
		 <div id="btnSave" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon icon-floppy" ></span>
			<span class="icon icon-load animate-spin"></span>
			<span class="menulbl">Guardar</span>
		</div>
		 <div id="btnEdit" class="app-bar-element no-flexible place-right disabled ">
			<span  class="icon icon-edit" ></span>
			<span class="icon icon-load animate-spin"></span>
			<span class="menulbl">Editar</span>
		</div>
		<div id="btnShow" class="app-bar-element no-flexible place-right" >
				<span class="off icon icon-list <?=CONFIG['ShowRow']==1?"hidden":""?>"></span>
				<span class="on icon icon-list-nested <?=CONFIG['ShowRow']==1?"":"hidden"?>"></span>
				<span class="menulbl"><?=CONFIG['ShowRow']==1?"Ocultar":"Mostrar"?></span>
		</div>
	</ul>
	<div id="conTxtBuscar" class=" mnu_extensible place-right"> 
		<input type="search" name="txtName" id="txtBuscar">
	</div>
	<div id="conTxtBuscar" class=" place-right"> 
		<input type="search" name="txtName" id="txtBuscar">
	</div>
</nav>
