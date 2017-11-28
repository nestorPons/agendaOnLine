<h1>Configuracion agendas</h1>
<h4>Puede cambiar el nombre de las agendas:</h4>
<h4>Seleccione las agendas que quiere que vean los clientes:</h4>
<form id="frmAg">
	<?php 
	$agendas = $Agendas->getAll('*',MYSQLI_ASSOC);

	foreach($agendas as $agenda){
		$i = $agenda['id'];
		if ($i>CONFIG['num_ag']) break;
		$checked = $agenda['mostrar']==0?"":"checked";
		$nom = $agenda['nombre'];

		?>
		<label id="agenda<?=$i?>">
			<input id="a<?=$i?>" type="checkbox" name="chck[]" value='<?=$i?>' <?=$checked?>>
			<input id = "txt<?=$i?>" type="text" name="nombre[]" placeholder="agenda<?=$i?>"
				value="<?=$nom?>">
		</label>
		<?php
	}?>
</form>