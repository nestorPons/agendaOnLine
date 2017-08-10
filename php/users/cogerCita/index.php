<div class="contenedor-stepper">
	<form  id="cogerCitaFrm">	
		<div class="stepper" data-role="stepper" data-start=0></div>
			<div id="stepper0" name="stepperagendas" class="steperCapa" data-value=0
				data-role= "popover" data-popover-position="top" data-popover-text="No hay ninguna agenda seleccionada">
					<h1>Seleccione agenda</h1> 
					<div>
					<?php 
 						$agenda[0]=1;
						for ($i=1;$i<=CONFIG['NumAg'];$i++){
							$checked=($agenda[0]==$i)?"checked":"";
							?>
							<label  for="agenda<?php echo$i?>">
								<input type='radio' name="agenda[]"  id="agenda<?php echo$i?>" value='<?php echo$i?>' <?php echo $checked?>>
								<span id="lblagenda<?php echo$i?>">
								<?php 
									$sql="SELECT nombre FROM agendas WHERE Id=$i AND Mostrar=1";
									$row=mysqli_fetch_row(mysqli_query($conexion,$sql));
									echo empty($row[0])?"agenda $i":$row[0];
								?>
								</span>
							</label>
							<?php
						}
					?>	
				</div>
				<button type="button" class="btn-danger cerrar">Cancelar</button>
				<button type="button" id="btnAceptaragendas" class="btn-success nextSteeper">Siguiente<i  class="icon-angle-right parpadear"></i></button>
			</div>
			<div id="stepper1" name="stepperServicios" class="steperCapa hidden" data-value=1
			data-role= "popover" data-popover-position="top" data-popover-text="No hay ningun servicio seleccionado">
				<?php include"../../php/users/cogerCita/servicios.php"?>
				<button type="button" class="btn-danger cerrar">Cancelar</button>
				<button type="button" id="btnAceptarServicios" class="btn-success nextSteeper">Siguiente<i  class="icon-angle-right parpadear"></i></button>
			</div>
			<div id="stepper2" class="steperCapa hidden" data-value=2>
					<?php 
						$nombreDp='dpCC';
						$minDate = 0;
						include "../../php/menus/datepicker.php" ;
					?>
				<h2>tiempo total de los servicios:<span id='tSer' class="resaltado"></span> min.</h2>	
				<div id="tablas" class="tablas">
					<div data-role="preloader" data-type="cycle" data-style="color" class="margin20"></div>
					<table id="principal" >					
					<?php for($i=1;$i<=count(HORAS);$i++){?>
						<tr  id="tr<?php echo$i?>">
							<td id="h<?php echo $i?>" class="hora" >
								<label class="label"  id="lbl<?php echo$i?>">
									<input type="radio" name="hora[]" id="<?php echo$i?>" value="<?php echo$i?>">
										<span class="lblhoras"><?php echo HORAS[$i]?></span> 
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