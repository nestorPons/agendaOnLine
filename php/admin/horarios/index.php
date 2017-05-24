<?php
include "consult.php";
$horarios = Horarios\horarios( $return_row = true);
include '../config/classAgenda.php';
$agendas = new config\agendas; 
$arr_agendas = $agendas->consulta();

?>
<h1>Horarios</h1>
<hr>
<form id='frmHorario'>
	<table class="tablas-mini">
		<thead>
			<th><span>Selección<span></th>
			<th><span>Agenda<span></th>
			<th><span>dia semana<span></th>
			<th><span>Inicio<span></th>
			<th><span>Fin<span></th>
		</thead>
		 <tbody>
			<?php 
				$n = 0 ;
				foreach($horarios as $horario){
				?>
			
				<tr id="<?php echo $horario['id']?>" class="<?php echo ($n ==  0) ? 'template':''; $n++ ?>">
					<td>
						<input type="checkbox" class="num" value="<?php echo $horario['id']?>"> 
					</td>
					<td>
						<select  class="num numero_agenda" name="numero_agenda[]">
							<?php 
							foreach($arr_agendas as $value){
								?>
								<option 
									value = <?php echo $value[0]?> 
									<?php echo $horario['agenda'] == $value[0]? "selected" : "" ;?>>
									<?php echo $value[1]?>
								</option>
								<?php 
							}?>
						</select>
					</td>
					<td>
						<select class="num dia_semana" name="dia_semana[]">
							<option value = 1 <?php echo $horario['dia'] ==  1 ? "selected" : "" ;?>>Lunes</option>
							<option value = 2 <?php echo $horario['dia'] ==  2 ? "selected" : "" ;?>>Martes</option>
							<option value = 3 <?php echo $horario['dia'] ==  3 ? "selected" : "" ;?>>Miércoles</option>
							<option value = 4 <?php echo $horario['dia'] ==  4 ? "selected" : "" ;?>>Jueves</option>
							<option value = 5 <?php echo $horario['dia'] ==  5 ? "selected" : "" ;?>>Viernes</option>
							<option value = 6 <?php echo $horario['dia'] ==  6 ? "selected" : "" ;?>>Sábado</option>
							<option value = 0 <?php echo $horario['dia'] ==  0 ? "selected" : "" ;?>>Domingo</option>
						</select>
					</td>
					<td>
						<input 
							type="time" 
							class="num hora_inicio time" 
							placeholder='00:00' 
							value="<?php echo date('H:i',strtotime($horario['inicio']))?>"> 
					</td>
					<td>
						<input 
							type="time" 
							class="num hora_fin time" 
							placeholder='00:00'  
							value="<?php echo date('H:i',strtotime($horario['fin'])) ?>">
					</td>
				</tr>
				<?php 
			} ?>
		 </tbody>
	</table>
</form>

