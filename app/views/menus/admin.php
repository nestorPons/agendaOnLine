<div id="mnuContacto" data-role="charm" data-position="right">
	<h1>Buzon de sugerencias</h1>
	<div class="">
		<form id="frmContact">
			<h4>Formulario de contacto ....</h4>
			<div class="iconClass-container icon-left">
				<input type="text" name="nombre" placeholder="nombre" value='<?=CONFIG['nombre_usuario']?>'>
				<i class="icon-user iconClass-inside"></i>
			</div>
			<!--
			<div class="iconClass-container icon-left">
				<input type="text" name="empresa" placeholder="Empresa" value='<?=CONFIG['nombre_empresa']?>'>
				<i class="icon-shop  iconClass-inside"></i>
			</div>
			-->
			<div class="iconClass-container icon-left">
				<input type="email" name="email" placeholder="Email de contacto" value='<?=CONFIG['email']?>'>
				<i class="icon-mail iconClass-inside"></i>
			</div>
			<div class="iconClass-container icon-left">
				<input type="tel" name="telefono" placeholder="Telefono" value='<?=CONFIG['tel']?>'>
				<i class="icon-phone iconClass-inside"></i>
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
<div id="mnuGeneral" data-role="charm" data-position="right">
	<?php include URL_VIEWS_ADMIN . 'general.php'?>
</div>
<div  id= "navbar" class="app-bar" data-role="appbar" >
	<div id="boton-menu" class="lnr-menu" ></div>
	
	<?php
	$cls_festivos = (!empty(FESTIVOS)) && (in_array(Date('md') , FESTIVOS )) ? 'c-red' : '' ;
	$fecha = isset($_POST['fecha'])?$_POST['fecha']:Date('Y-m-d');
	?>
	<ul class="app-bar-menu place-right no-flexible" data-flexdirection="reverse" title="Salir">
		<li id="btnExit" class="app-bar-element no-flexible place-right">
			<i class="lnr-power-switch " ></i>
		</li>
		<li id="btnData" class="fnToggleCharm app-bar-element no-flexible place-right "  data-frm="mnuGeneral" title="Datos de usuario">
			<i class="lnr-user"></i>
		</li>
		<li id= "btnContacto" class="fnToggleCharm app-bar-element no-flexible place-right "  data-frm="mnuContacto" title="Contacto">
			<i  class=" lnr-envelope"></i>
		</li>
		<li class=" app-bar-element no-flexible place-right "  title="Version">
			<span><?=VERSION?></span>
		</li>
	</ul>
	<!--menu herramientas-->

	<div class = "contenedor-datepicker">
		<i data-action="-1" class="icon-left-open idDateAction" data-disabled=false></i>
		<i data-action="1" class="icon-right-open idDateAction" data-disabled=false></i>
		
		<input class='datepicker date <?= $cls_festivos?>' 
		type='text' 
		value='<?=core\Tools::formatofecha($fecha)?>'
		data-festivos-show=true data-min-date=<?= $minDate??null;?>>
		
	</div>
	<ul id="tools" class="app-bar-menu no-flexible" data-flexdirection="reverse">
		<div id="btnSearch" class="app-bar-element no-flexible   ">
			<i  class="icono-nav lnr-magnifier"></i>
			<span  class="menulbl">Buscar</span>
		</div>
		<div id="btnReset" class="app-bar-element no-flexible ">
			<i  class="lnr-undo"></i>
			<span  class="menulbl">Refrescar</span>
		</div>
		<div id="btnAdd" class="app-bar-element no-flexible  " data-value=0>
			<i  class="lnr-plus-circle" ></i>
			<span  class="menulbl">Nuevo</span>
		</div>
		<div id="btnDel" class="app-bar-element no-flexible   ">
			<i  class="lnr-trash"></i>
			<span  class="menulbl">Eliminar</span>
		</div>
			<div id="btnSave" class="app-bar-element no-flexible   ">
			<i class="icon-floppy " ></i>
			<span class="menulbl">Guardar</span>
		</div>
			<div id="btnEdit" class="app-bar-element no-flexible   ">
			<i class="icon-edit" ></i>
			<span class="menulbl">Editar</span>
		</div>
		<div id="btnShow" class="app-bar-element no-flexible " >
			<i class="<?=CONFIG['ShowRow']==1?"lnr-line-spacing":"lnr-indent-decrease"?>"></i>
			<span class="menulbl"><?=CONFIG['ShowRow']==1?"Ocultar":"Mostrar"?></span>
		</div>
	</ul>
	<div id="conTxtBuscar" class=" "> 
		<input type="search" name="txtName" id="txtBuscar">
	</div>
</div>
