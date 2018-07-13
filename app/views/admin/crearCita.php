<div class="body">
	<div class="stepper" data-role="stepper" data-start=0></div>
		<form  id="frmCrearCita">	
			<div id="stepper0" class="steperCapa" data-value=0>
				<?php require_once URL_VIEWS_ADMIN . "crearCita/usuarios.php" ?>
			</div>
			<div id="stepper1"  name="stepperServicios" class="steperCapa" data-value=1
				data-role= "popover" data-popover-position="top" data-popover-text="No hay ningun servicio seleccionado">
				<?php require_once URL_VIEWS_ADMIN . "crearCita/servicios.php" ?>
			</div>
			<div id="stepper2" class="steperCapa" data-value=2>	
				<h2>tiempo total de los servicios:<span id='tSer' class="resaltado"></span> min.</h2>	
				<div id="tablas" class="tablas tblhoras">
				</div>
			</div>
		</form>	
	</div>