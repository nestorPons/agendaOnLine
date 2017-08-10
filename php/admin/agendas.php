<h1>Configuracion agendas</h1>
<h2>Seleccione las agendas que quiere que vean los clientes:</h2>
<form id="frmAg">
	<?php 
	for ($i=1;$i<=6;$i++){
		$b = $i+5;
		$disabled = $i<=CONFIG['NumAg']?"":"disabled";
		$disabledb = $b<=CONFIG['NumAg']?"":"disabled";
		
		$row=$conn->assoc("SELECT * FROM agendas WHERE Id = $i LIMIT 1");
		$checked = $row['Mostrar']==0?"":"checked";
		$nom = $disabled=="disabled"?"":$row['nombre'];
		
		$row=$conn->assoc("SELECT * FROM agendas WHERE Id = $b LIMIT 1");
		$checkedb = $row['Mostrar']==0?"":"checked";
		$nomb = $disabledb=="disabled"?"":$row['nombre'];
		?>
		<label id="agenda<?=$i?>">
			<input id="a<?=$i?>" type="checkbox" name="chck[]" value='<?=$i?>' <?= $disabled." ".$checked?>>
			<input id = "txt<?=$i?>" type="text" name="nombre[]" placeholder="agenda<?=$i?>"
				value="<?=$nom?>" <?=$disabled?>>
		</label>
		<?php
	}?>
</form>
<div id="popupagendas">
<div class="content-popup hidden">
	<div class="close"><a href="#" class="icon-cancel-circled2 x6 close"></a></div>
		<h1>Editando servicios</h1>
		<form  id='mensaje'>
			¿Desea contratar más agendas?
			<p class="submit">
				<input type="button" id="cancelar" value="Cancelar" class="btn-danger">
				<input type="submit" id="aceptar" value="Aceptar" class="btn-success">
			</p>
		</form>
	</div>
</div>
