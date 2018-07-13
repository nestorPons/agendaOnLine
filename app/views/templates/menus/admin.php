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
	<div id="boton-menu" class="lnr-menu" ></div>
	
	<?php
$cls_festivos = (!empty(FESTIVOS)) && (in_array(Date('md') , FESTIVOS )) ? 'c-red' : '' ;
$fecha = isset($_POST['fecha'])?$_POST['fecha']:Date('Y-m-d');
?>
	<div class = "contenedor-datepicker">

		<i data-action="-1" class="icon-left-open idDateAction" data-disabled=false></i>
		<i data-action="1" class="icon-right-open idDateAction" data-disabled=false></i>
		
		<input class='datepicker date <?= $cls_festivos?>' 
		type='text' 
		value='<?=core\Tools::formatofecha($fecha)?>'
		data-festivos-show=true data-min-date=<?= $minDate??null;?>>
		
	</div>
	
	<?php 
	if(!$Device->isMovile){?>
		<h1 id="tile_seccion">Reserva de citas</h1>
	<?php }?>

	<ul class="app-bar-menu place-right no-flexible" data-flexdirection="reverse">
		<li id="btnExit" class="app-bar-element no-flexible place-right">
			<a href="/<?=CODE_EMPRESA?>/logout" id="mnuUserSalirSession" class="lnr-power-switch ">
		</a>
	</li>
	<li id= "btnContacto" class="app-bar-element no-flexible place-right">
		<i  class=" lnr-envelope"></i>
	</li>
</ul>
<!--menu herramientas-->

		<ul class="herramientas app-bar-menu place-right no-flexible" data-flexdirection="reverse">
		 <div id="btnSearch" class="app-bar-element no-flexible place-right disabled ">
			<span  class="lnr-magnifier"></span>
			<span  class="menulbl">Buscar</span>
		</div>
		<div id="btnOptions" class="app-bar-element no-flexible place-right disabled">
			<a class="dropdown-toggle no-flexible place-right  ">
				<span class="icon-cog"></span>
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
			<span  class="lnr-undo"></span>
			<span  class="menulbl">Refrescar</span>
		</div>
		 <div id="btnDel" class="app-bar-element no-flexible place-right disabled ">
			<span  class="lnr-trash"></span>
			<span  class="menulbl">Eliminar</span>
		</div>
		 <div id="btnAdd" class="app-bar-element no-flexible place-right disabled" data-value=0>
			<span  class="lnr-plus-circle" ></span>
			<span  class="menulbl">Nuevo</span>
		</div>
		 <div id="btnSave" class="app-bar-element no-flexible place-right disabled ">
			<span  class="lnr-thumbs-up" ></span>
			<span class="lnr-sync animate-spin"></span>
			<span class="menulbl">Guardar</span>
		</div>
		 <div id="btnEdit" class="app-bar-element no-flexible place-right disabled ">
			<span  class=" icon-edit" ></span>
			<span class="icon-load animate-spin"></span>
			<span class="menulbl">Editar</span>
		</div>
		<div id="btnShow" class="app-bar-element no-flexible place-right" >
				<span class="off lnr-star <?=CONFIG['ShowRow']==1?"hidden":""?>"></span>
				<span class="on lnr-star-empty <?=CONFIG['ShowRow']==1?"":"hidden"?>"></span>
				<span class="menulbl"><?=CONFIG['ShowRow']==1?"Ocultar":"Mostrar"?></span>
		</div>
	</ul>
	<div id="conTxtBuscar" class=" place-right"> 
		<input type="search" name="txtName" id="txtBuscar">
	</div>
</nav>
