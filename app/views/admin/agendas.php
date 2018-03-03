<h1>Configuracion agendas</h1>
<h4>Puede cambiar el nombre de las agendas:</h4>
<h4>Seleccione las agendas que quiere que vean los clientes:</h4>
<form id="frmAg">
	<?php 

	foreach($Agendas->get as $agenda){
		$i = $agenda[0];
		if ($i>CONFIG['num_ag']) break;
		$checked = $agenda[2]==0?"":"checked";
		$nom = $agenda[1];

		?>
		<label id="agenda<?=$i?>">
			<input id="a<?=$i?>" type="checkbox" name="chck[]" value='<?=$i?>' <?=$checked?>>
			<input id = "txt<?=$i?>" type="text" name="nombre[]" placeholder="agenda<?=$i?>"
				value="<?=$nom?>">
		</label>
		<?php
	}?>
</form>