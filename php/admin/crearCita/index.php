<?php 
session_start(); 
include "../../connect/tools.php";
?>
<div class="body">
	<div class="stepper" data-role="stepper" data-start=0></div>
		<form  id="frmCrearCita">	
			<div id="stepper0" class="steperCapa" data-value=0>
				<?php include "usuario.php" ?>
			</div>
			<div id="stepper1"  name="stepperServicios" class="steperCapa" data-value=1
				data-role= "popover" data-popover-position="top" data-popover-text="No hay ningun servicio seleccionado">
				<?php include "servicios.php" ?>
			</div>
			<div id="stepper2" class="steperCapa" data-value=2>	
				<?php 
					$nombreDp='dpCC';
					include "../../../php/menus/datepicker.php" ;
				?>
				<h2>Tiempo total de los servicios:<span id='tSer' class="resaltado"></span> min.</h2>	
				<div id="tablas" class="tablas tblHoras">
				<!--	<div data-role="preloader" data-type="cycle" data-style="color" class="margin20"></div>-->
				</div>
			</div>

		</form>	
	</div>	