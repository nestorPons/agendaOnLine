<?php require_once('../../connect/clsConfig.php') ; ?>
<h1>Configuración</h1>
<form id="frmConfig" enctype="multipart/form-data"  class="chck-container">
		<label>
			<input type='checkbox' 	name='showInactivas' id='showInactivas' value=1  <?php if(!empty(CONFIG['ShowRow']))echo'checked'?>>
			¿Mostrar horas inactivas?
		</label>
		<label>
			<input type='checkbox' 	name='sendMailAdmin' value=1  <?php if(!empty(CONFIG['sendMailAdmin']))echo'checked'?>>
			¿Enviar email recordatotrio, cuando el administrador guarde una cita?
		</label>
		<label>
			<input type='checkbox' 	name='sendMailUser' value=1 <?php if(!empty(CONFIG['sendMailUser']))echo'checked'?>>
			¿Enviar email recordatorio, cuando el cliente reserve una cita?
		</label>
		<label>
			<input type='checkbox' 	name='festivosON' value=1  <?php if(!empty(CONFIG['festivosON']))echo'checked'?>>
			¿Desactivar los dias festivos en el calendario de los usuarios?
		</label>
		<label>
			<input type='input' name='minTime' id='minTime' value=<?php echo CONFIG['MinTime']?>> 
			Reservar hora con un mínimo de minutos.
		</label>
		<label>
			<div class="aling-left" > 
				<span>Subir la imagen del LOGO de la empresa:</span>
				<input type="file" name="fileLogo" accept="image/jpg image/png image/ico">
			</div>
		</label>
		<label><div id="respuestaLogo"></div></label>
</form>