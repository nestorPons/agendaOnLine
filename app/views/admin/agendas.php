<form id="frmAg">
	<div class="table">
		<div class="tr">
			<label class="col1">Eliminar</label>
			<label class="col2">Nombre</label>
			<label class="col3">Mostrar</label>
		</div>
		<?php 
		$count = 0 ; 
		foreach($Agendas->get() as $agenda){
			if ($count>CONFIG['num_ag']) break;
			$count ++ ;

			$i = $agenda[0];

			$checked = $agenda[2]==0?"":"checked";
			$nom = $agenda[1];
			?>
			<div class ="tr datos">
				<div class="col1">
					<span id=<?=$i?> class="icon-trash fnDel"></span>
				</div>
				<div class="col2">
					<input id ="<?='nameAgendaConfig'.$i?>" type="text" name="nombre[]" placeholder="Nombre" value="<?=$nom?>">
				</div>
				<div class="col3">
					<input id="a<?=$i?>" type="checkbox" name="chck[]" value='<?=$i?>' <?=$checked?>>
				</div>
			</div>
			<?php
		}?>
	</div>
</form>
<br>
<a href="mailto:<?= ADMIN_EMAIL?>">Solicita otra agenda al administrador</a>