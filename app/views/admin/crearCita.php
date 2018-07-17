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
				<?php
				if($User->isUser()){
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
				}
				?>

				<h2>tiempo total de los servicios:<span id='tSer' class="resaltado"></span> min.</h2>	
				<div id="tablas" class="tablas tblhoras">
				</div>
			</div>
		</form>	
	</div>