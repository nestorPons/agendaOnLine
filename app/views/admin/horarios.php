<h1>horarios</h1>
<hr>
<form id='frmHorario'>
	<select  class="num numero_agenda" name="numero_agenda[]">
		<!--<option value = 0 > <span > Todas </span> </option>-->
		<?php 
		foreach($Agendas->get() as $value){
			?>
			<option value = <?=$value[0]?>> <?=$value[1]?></option>
			<?php 
		}?>
	</select>

	<table class="tablas aling-left">

		<thead>
			<th><span>Dia inicio<span></th>
			<th><span>Dia fin<span></th>
			<th><span>Hora/min inicio<span></th>
			<th><span>Hora/min fin<span></th>
		</thead>
		 <tbody>
			<tr>
				<td>
					<select class="dia_semana" name="dia_semana[]">
						<option value = 1>Lunes</option>
						<option value = 2>Martes</option>
						<option value = 3>Miércoles</option>
						<option value = 4>Jueves</option>
						<option value = 5>Viernes</option>
						<option value = 6>Sábado</option>
						<option value = 0>Domingo</option>
					</select>
				
				</td>

				<td>
					<select class="dia_semana" name="dia_semana[]">
						<option value = 1>Lunes</option>
						<option value = 2>Martes</option>
						<option value = 3>Miércoles</option>
						<option value = 4>Jueves</option>
						<option value = 5>Viernes</option>
						<option value = 6>Sábado</option>
						<option value = 0>Domingo</option>
					</select>		
				</td>
				<td>
AKI:: cambiar los selects por inputs time 
					<select class="horas inline" name="">
						<?php 
						for($i=0; $i<24; $i++){
							
							?>
							<option value=<?=$i?>><?=str_pad($i,2,"0",STR_PAD_LEFT)?></option>
							<?php
						}
						?>
					</select>	
					<select class="minutos inline" name="">
						<option value=0>00</option>
						<option value=15>15</option>
						<option value=30>30</option>
						<option value=45>45</option>
					</select>	
				</td>
				<td>
					<select class="horas inline" name="">
						<?php 
						for($i=0; $i<24; $i++){
							?>
							<option value=<?=$i?>><?=str_pad($i,2,"0",STR_PAD_LEFT)?></option>
							<?php
						}
						?>
					</select>	
					<select class="minutos inline" name="">
						<option value=0>00</option>
						<option value=15>15</option>
						<option value=30>30</option>
						<option value=45>45</option>
					</select>	
				</td>
			</tr>
		 </tbody>
	</table>
</form>

