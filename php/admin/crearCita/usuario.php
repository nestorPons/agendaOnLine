
<div id='selAgendas'>
	<?php 
		$agenda[0]=1;
		for ($i=1;$i<=$_SESSION['CONFIG']['NumAg'];$i++){
			$checked=($agenda[0]==$i)?"checked":"";
			?>
			<label  for="agenda<?=$i?>">
				<input type='radio' name="agenda[]"  id="agenda<?=$i?>" value='<?=$i?>' <?= $checked?>>
				<span id="lblAgenda<?=$i?>">
				<?= empty($row[0])?"Agenda $i":$_SESSION['AGENDAS'][0]['Nombre'];?>
				</span>
			</label>
			<?php
		}
	?>	
</div>
<datalist id ='lstClientes'>
	<?php
	foreach($_SESSION['USUARIOS'] as $row){
		if ($row[10]==0){
			?>
			<option 
				data-id="<?= normaliza($row[1])?>" 
				value="<?= $row[1]?>" >
				<?= $row[0]?>
			</option>
			<?php
		}
	}
	?>
</datalist>
<div class="iconClass-container icon-left">
	<input type="search" name='cliente' id='cliente' list='lstClientes' placeholder='Introduzca el nombre del cliente' class="txt" 
		data-role="popover" data-popover-position="bottom" data-popover-text="Error falta el nombre" 
		data-popover-background="bg-red" data-popover-background="bg-green" data-popover-color="fg-white">
	<span class="iconClass-inside icon-user"></span>
</div>
<div class="iconClass-container icon-left">
	<textarea id="crearCitaNota" name='nota' class="txt" rows=1 placeholder='Introduzca alguna nota de la cita'  data-autoresize ></textarea>
	<span class="iconClass-inside icon-note"></span>
</div>

<button type="button" class="btn-danger cancelar">Cancelar</button>
<button type="button" class="btn-success siguiente">Siguiente<i class="icon-angle-right"></i></button>

