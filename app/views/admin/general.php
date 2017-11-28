<form id='generalFrm'>	
	<div class="iconClass-container icon-left">
		<input type='text' name='nombre' value='<?= CONFIG['nombre']?>' placeholder='nombre comercial' require>
		<span class="iconClass-inside icon-shop"></span>
	</div>
		<div class="iconClass-container icon-left">
		<input type='number' name='nif' value='<?= CONFIG['nif']?>'	placeholder='NIF' min="11111" max="999999" require>
		<span class="iconClass-inside icon-vcard"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='email' name='email' value='<?= CONFIG['email']?>'	placeholder='Email de contacto' require>
		<span class="iconClass-inside left icon-mail"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='tel' name='tel' value='<?= CONFIG['tel']?>'	placeholder='Telefono del centro' require>
		<span class="iconClass-inside icon-phone"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='dir' value='<?= CONFIG['dir']?>'	placeholder='Dirección' require>
		<span class="iconClass-inside left icon-street-view"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='poblacion' value='<?= CONFIG['poblacion']?>'	placeholder='Poblacion' require>
		<span class="iconClass-inside left icon-home"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='text' 	name='pais' value='<?= CONFIG['pais']?>'	placeholder='Pais' require>
		<span class="iconClass-inside left icon-flag-empty"></span>
	</div>
		<div class="iconClass-container icon-left">
		<input type='text' 	name='cp' value='<?= CONFIG['cp']?>'	placeholder='codigo Postal' require>
		<span class="iconClass-inside left icon-mail-1"></span>
	</div>
	<div class="iconClass-container icon-left">
		<input type='url' 	name='web' value='<?= CONFIG['web']?>'	placeholder='Pagina WEB' require>
		<span class="iconClass-inside left icon-google"></span>
	</div>
</form>
<p class="submit">
	<button type="button" class="btn-primary" id="btnCambiarPass" data-value="Contraseña">Contraseña</button>
</p>
