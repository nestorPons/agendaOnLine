<form id='generalFrm'>	
	<div class="iconClass-container icon-left">
		<input type='text' name='nombre_usuario' value='<?= CONFIG['nombre_usuario']?>' placeholder='nombre usuario' require>
		<span class="iconClass-inside icon-user"></span>
	</div>
		<div class="iconClass-container icon-left">
		<input type='text' name='dni' value='<?= CONFIG['dni']?>'	placeholder='NIF' require>
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
		<input type='text' 	name='provincia' value='<?= CONFIG['provincia']?>'	placeholder='Provincia' require>
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
