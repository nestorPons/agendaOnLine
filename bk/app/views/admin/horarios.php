<h1>horarios</h1>
<hr>

<form id='frmHorario'>
	<div class="iconClass-container icon-left">
	<span class="caption">Agendas</span>
		<select id="agenda_horario">
		<?php 
		foreach($Agendas->get() as $agenda){
			?>
			<option value = "<?= $agenda[0]?>"><?= $agenda[1]?></option>
			<?php 
		}?>
		</select>
	</div>
	</br>
	<?php 
	foreach($horarios as $horario){
		?>
		<div id="horario_<?=$horario['id']?>" agenda="<?=$horario['agenda']?>" 
		class="lineaHorarios <?php if(!$horario['agenda']==0)echo'ocultar';?>">

			<input type="checkbox" class="" value=""> 

			<div class="iconClass-container icon-left inline">
				<span class="caption">Inicio dia semana </span>
				<select class="idDiaInicio">
					<option value = 1 <?= $horario['dia_inicio'] ==  1 ? "selected" : "" ;?> >Lunes</option>
					<option value = 2 <?= $horario['dia_inicio'] ==  2 ? "selected" : "" ;?> >Martes</option>
					<option value = 3 <?= $horario['dia_inicio'] ==  3 ? "selected" : "" ;?> >Miércoles</option>
					<option value = 4 <?= $horario['dia_inicio'] ==  4 ? "selected" : "" ;?> >Jueves</option>
					<option value = 5 <?= $horario['dia_inicio'] ==  5 ? "selected" : "" ;?> >Viernes</option>
					<option value = 6 <?= $horario['dia_inicio'] ==  6 ? "selected" : "" ;?> >Sábado</option>
					<option value = 0 <?= $horario['dia_inicio'] ==  0 ? "selected" : "" ;?> >Domingo</option>
				</select>
			</div>
			<div class="iconClass-container icon-left inline">
				<span class="caption">Fin dia semana </span>
				<select class="idDiaFin">
					<option value = 1 <?= $horario['dia_fin'] ==  1 ? "selected" : "" ;?> >Lunes</option>
					<option value = 2 <?= $horario['dia_fin'] ==  2 ? "selected" : "" ;?>>Martes</option>
					<option value = 3 <?= $horario['dia_fin'] ==  3 ? "selected" : "" ;?>>Miércoles</option>
					<option value = 4 <?= $horario['dia_fin'] ==  4 ? "selected" : "" ;?>>Jueves</option>
					<option value = 5 <?= $horario['dia_fin'] ==  5 ? "selected" : "" ;?>>Viernes</option>
					<option value = 6 <?= $horario['dia_fin'] ==  6 ? "selected" : "" ;?>>Sábado</option>
					<option value = 0 <?= $horario['dia_fin'] ==  0 ? "selected" : "" ;?>>Domingo</option>
				</select>
			</div>			
			<div class="iconClass-container icon-left inline">
				<span class="caption">Hora inicio </span>
				<input class="idHoraInicio" type="time" value="<?= $horario['hora_inicio']?>" step="900" >
			</div>
			<div class="iconClass-container icon-left inline">
				<span class="caption">Hora fin</span>
				<input class="idHoraFin" type="time" value="<?= $horario['hora_fin']?>" step="900" >
			</div>
		</div>			
		<?php
	}?>		
</form>

