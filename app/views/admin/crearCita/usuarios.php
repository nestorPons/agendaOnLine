<div id='selagendas'>
	<?php 
	
		foreach ($agendas as $key => $agenda){
			if ($key>=CONFIG['num_ag']) break;
			$id = $agenda[0];
			$nombre = $agenda[1];
			$mostrar = $agenda[2];
			$checked=($key==0)?"checked":"";
			?>
			<label  for="agenda<?=$id?>">
				<input type='radio' name="agenda[]"  id="agenda<?=$id?>" value='<?=$id?>' <?= $checked?>>
				<span id="lblagenda<?=$id?>">
				<?= empty($nombre)?"agenda $id":$nombre;?>
				</span>
			</label>
			<?php
		}
	?>	
</div>

<div class="iconClass-container icon-left">
	<input type="<?=isset($zoneUsers)?'hidden':'search'?>" name='cliente' id='cliente' list='lstClientes' placeholder='Introduzca el nombre del cliente' class="txt" 
		value ="<?=isset($zoneUsers)?$User->nombre:''?>"
		data-role="popover" data-popover-position="bottom" data-popover-text="Error falta el nombre" 
		data-popover-background="bg-red" data-popover-background="bg-green" data-popover-color="fg-white">
	<span class="iconClass-inside icon-user"></span>
</div>
<div class="iconClass-container icon-left">
	<textarea id="crearCitaNota" name='nota' class="txt" rows=1 placeholder='Nota para la cita'  data-autoresize ></textarea>
	<span class="iconClass-inside icon-note"></span>
</div>

<button type="button" class="btn-danger cancelar">Cancelar</button>
<button type="button" class="btn-success siguiente">Siguiente<i class="icon-angle-right"></i></button>

