<h1>horarios</h1>
<hr>

<form id='frmHorario'>
	<div class="iconClass-container icon-left">
	<span class="caption">Agendas</span>
		<select id="agenda_horario">
		<?php 
		foreach($Agendas->get() as $value){
			?>
			<option value = <?= $value[0]?>>
				<?= $value[1]?>
			</option>
			<?php 
		}?>
		</select>
	</div>
	</br>
	<div class="lineaHorarios">

			<input type="checkbox" class="" value=""> 

		<div class="iconClass-container icon-left inline">
			<span class="caption">Inicio dia semana </span>
			<select class="idDiaInicio">
				<option value = 1 >Lunes</option>
				<option value = 2 >Martes</option>
				<option value = 3 >Miércoles</option>
				<option value = 4 >Jueves</option>
				<option value = 5 >Viernes</option>
				<option value = 6 >Sábado</option>
				<option value = 0 >Domingo</option>
			</select>
		</div>
		<div class="iconClass-container icon-left inline">
			<span class="caption">Fin dia semana </span>
			<select class="idDiaFin">
				<option value = 1 >Lunes</option>
				<option value = 2 >Martes</option>
				<option value = 3 >Miércoles</option>
				<option value = 4 >Jueves</option>
				<option value = 5 >Viernes</option>
				<option value = 6 >Sábado</option>
				<option value = 0 >Domingo</option>
			</select>
		</div>			
		<div class="iconClass-container icon-left inline">
			<span class="caption">Hora inicio </span>
			<input class="idHoraInicio" type="time" value="09:00" step="900" >
		</div>
		<div class="iconClass-container icon-left inline">
			<span class="caption">Hora fin</span>
			<input class="idHoraFin" type="time" value="20:00" step="900" >
		</div>
	</div>					
</form>

