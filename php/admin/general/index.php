<form id='generalFrm' action="">	
	<div class="iconClass-container icon-left">
		<input type='text' name='nombre' value='<?php echo CONFIG['Nombre']?>' placeholder='Nombre comercial'>
		<span class="iconClass-inside icon-shop"></span>
	</div>
		<div class="iconClass-container icon-left">
		<input type='text' name='nif' value='<?php echo CONFIG['NIF']?>'	placeholder='NIF'>
		<span class="iconClass-inside icon-vcard"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='email' value='<?php echo CONFIG['Email']?>'	placeholder='Email de contacto'>
		<span class="iconClass-inside left icon-mail"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='tel' name='tel' value='<?php echo CONFIG['Tel']?>'	placeholder='Telefono del centro'>
		<span class="iconClass-inside icon-phone"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='dir' value='<?php echo CONFIG['Dir']?>'	placeholder='Dirección'>
		<span class="iconClass-inside left icon-street-view"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='poblacion' value='<?php echo CONFIG['Poblacion']?>'	placeholder='Poblacion'>
		<span class="iconClass-inside left icon-home"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='pais' value='<?php echo CONFIG['Pais']?>'	placeholder='Pais'>
		<span class="iconClass-inside left icon-flag-empty"></span>
	</div>
		<div class="iconClass-container icon-left">
		<input type='text' 	name='cp' value='<?php echo CONFIG['CP']?>'	placeholder='Codigo Postal'>
		<span class="iconClass-inside left icon-mail-1"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='web' value='<?php echo CONFIG['Web']?>'	placeholder='Pagina WEB'>
		<span class="iconClass-inside left icon-google"></span>
	</div>
	<p class="submit">
		<button type="button" class="btn-primary" id="btnCambiarPass" data-value="Contraseña">Contraseña</button>
		<button type="submit" class="btn-success btnLoad" id="btnGuardarCita" data-value="Guardar">Guardar</button>
	</p>
</form>
