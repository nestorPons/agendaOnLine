<?php 
	$arr_agendas = $conn->all( "SELECT * FROM agendas" );
	$horarios = new horarios\Horarios();
?>
<h1>horarios</h1>
<hr>
<form id='frmhorario'>
	<table class="tablas-mini">
		<thead>
			<th><span>Selección<span></th>
			<th><span>agenda<span></th>
			<th><span>dia semana<span></th>
			<th><span>Inicio<span></th>
			<th><span>Fin<span></th>
		</thead>
		 <tbody>
			<?php 
				$n = 0 ;
				foreach($horarios->consult() as $horario){
				?>
			
				<tr id="<?= $horario['id']?>" class="<?= ($n ==  0) ? 'template':''; $n++ ?>">
					<td>
						<input type="checkbox" class="num" value="<?= $horario['id']?>"> 
					</td>
					<td>
						<select  class="num numero_agenda" name="numero_agenda[]">
							<?php 
							foreach($arr_agendas as $value){
								?>
								<option 
									value = <?= $value[0]?> 
									<?= $horario['agenda'] == $value[0]? "selected" : "" ;?>>
									<?= $value[1]?>
								</option>
								<?php 
							}?>
						</select>
					</td>
					<td>
						<select class="num dia_semana" name="dia_semana[]">
							<option value = 1 <?= $horario['dia'] ==  1 ? "selected" : "" ;?>>Lunes</option>
							<option value = 2 <?= $horario['dia'] ==  2 ? "selected" : "" ;?>>Martes</option>
							<option value = 3 <?= $horario['dia'] ==  3 ? "selected" : "" ;?>>Miércoles</option>
							<option value = 4 <?= $horario['dia'] ==  4 ? "selected" : "" ;?>>Jueves</option>
							<option value = 5 <?= $horario['dia'] ==  5 ? "selected" : "" ;?>>Viernes</option>
							<option value = 6 <?= $horario['dia'] ==  6 ? "selected" : "" ;?>>Sábado</option>
							<option value = 0 <?= $horario['dia'] ==  0 ? "selected" : "" ;?>>Domingo</option>
						</select>
					</td>
					<td>
						<input 
							type="time" 
							class="num hora_inicio time" 
							placeholder='00:00' 
							value="<?= date('H:i',strtotime($horario['inicio']))?>"> 
					</td>
					<td>
						<input 
							type="time" 
							class="num hora_fin time" 
							placeholder='00:00'  
							value="<?= date('H:i',strtotime($horario['fin'])) ?>">
					</td>
				</tr>
				<?php 
			} ?>
		 </tbody>
	</table>
</form>

