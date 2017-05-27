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
				<div id="tablas" class="tablas">
				<!--	<div data-role="preloader" data-type="cycle" data-style="color" class="margin20"></div>-->
					<table id="principal">						
						<?php for($i=1;$i<= count($_SESSION['HORAS']);$i++){?>
							<tr  id="tr<?php echo$i?>">
								<td class="hora">
									<label class="label"  id="lbl<?php echo$i?>">
										<input type="radio" name="hora[]" id="<?php echo$i?>" value="<?php echo$i?>">
											<span class="lblHoras"><?php echo $_SESSION['HORAS'][$i]?></span> 
										</input>
									</label>
								</td>
							</tr>
						<?php }?>
					</table>
				</div>
			</div>

		</form>	
	</div>	