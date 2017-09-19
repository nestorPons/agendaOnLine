<form id='generalFrm' action="">	
	<div class="iconClass-container icon-left">
		<input type='text' name='nombre' value='<?= CONFIG['nombre']?>' placeholder='nombre comercial'>
		<span class="iconClass-inside icon-shop"></span>
	</div>
		<div class="iconClass-container icon-left">
		<input type='text' name='nif' value='<?= CONFIG['nif']?>'	placeholder='NIF'>
		<span class="iconClass-inside icon-vcard"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='email' value='<?= CONFIG['email']?>'	placeholder='Email de contacto'>
		<span class="iconClass-inside left icon-mail"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='tel' name='tel' value='<?= CONFIG['tel']?>'	placeholder='Telefono del centro'>
		<span class="iconClass-inside icon-phone"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='dir' value='<?= CONFIG['dir']?>'	placeholder='Dirección'>
		<span class="iconClass-inside left icon-street-view"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='poblacion' value='<?= CONFIG['poblacion']?>'	placeholder='Poblacion'>
		<span class="iconClass-inside left icon-home"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='pais' value='<?= CONFIG['pais']?>'	placeholder='Pais'>
		<span class="iconClass-inside left icon-flag-empty"></span>
	</div>
		<div class="iconClass-container icon-left">
		<input type='text' 	name='cp' value='<?= CONFIG['cp']?>'	placeholder='codigo Postal'>
		<span class="iconClass-inside left icon-mail-1"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='web' value='<?= CONFIG['web']?>'	placeholder='Pagina WEB'>
		<span class="iconClass-inside left icon-google"></span>
	</div>
	<p class="submit">
		<button type="button" class="btn-primary" id="btnCambiarPass" data-value="Contraseña">Contraseña</button>
	</p>
</form>
