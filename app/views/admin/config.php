<form id="frmConfig" enctype="multipart/form-data"  class="chck-container" type="POST">
	<div>
		<input type='checkbox' name='showInactivas' id='showInactivas' value=1  <?php if(!empty(CONFIG['ShowRow']))echo'checked'?>/>
		<label for='showInactivas'>	¿Mostrar horas inactivas?</label>
	</div>
	<div>
		<input type='checkbox' 	id='sendMailAdmin'  value=1  <?php if(!empty(CONFIG['sendMailAdmin']))echo'checked'?>>
		<label for='sendMailAdmin'>	¿Enviar email recordatotrio, cuando el administrador guarde una cita? </label>
	</div>
	<div>
		<input type = 'checkbox' id='sendMailUser' name='sendMailUser' value=1 <?php if(!empty(CONFIG['sendMailUser']))echo'checked'?>>
		<label for = 'sendMailUser'> ¿Enviar email recordatorio, cuando el cliente reserve una cita? </label>
	</div>
	<div>
		<input type='checkbox' 	id='festivosON' name='festivosON' value=1  <?php if(!empty(CONFIG['festivosON']))echo'checked'?>>
		<label for='festivosON'>	¿Desactivar los dias festivos en el calendario de los usuarios?	</label>
	</div>
	<div>
		<input type='input' name='minTime' id='minTime' value=<?=CONFIG['minTime']?>> 
		<label for='minTime'>Reservar hora con un mínimo de minutos.</label>
	</div>
	<div class="aling-left" > 
		<label for="fileLogo">Subir la imagen del LOGO de la empresa:</label>
		<input type="file" id="fileLogo" name="fileLogo" accept="image/jpg image/png image/ico">
	</div>
	<label for="respuestaLogo"><div id="respuestaLogo"></div></label>
</form>