<div id='selagendas'>
	<?php 	
	foreach ($Agendas->get() as $key => $agenda){
		if ($key>=CONFIG['totalAgendas']) break;

		if(!(!$User->isAdmin()&&$agenda[2]==0)){
			$id = $agenda[0]??-1;
			$nombre = $agenda[1]??'';
			$mostrar = $agenda[2]??'';
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
	}
		?>	
</div>

<div class="iconClass-container icon-left">
	<input type="<?=$User->isUser()?'hidden':'search'?>" name='cliente' id='cliente' list='lstClientes' placeholder='Introduzca el nombre del cliente' class="txt" 
		value ="<?=$User->isUser()?$User->nombre:''?>"
		data-role="popover" data-popover-position="bottom" data-popover-text="Error falta el nombre" 
		data-popover-background="bg-red" data-popover-background="bg-green" data-popover-color="fg-white">
		<?php if($User->isAdmin()){?>
			<span class="iconClass-inside icon-user"></span>
			<?php
		}?>
</div>
<div class="iconClass-container icon-left">
	<textarea id="crearCitaNota" name='nota' class="txt" rows=1 placeholder='Nota para la cita'  data-autoresize ></textarea>
	<span class="iconClass-inside icon-note"></span>
</div>
<div class="iconClass-container">
	<button type="button" class="btn-success siguiente">Siguiente<i class="icon-angle-right"></i></button>
	<button type="button" class="btn-danger cancelar">Cancelar</button>
</div>
<br>
