<h1>Festivos</h1>

<table id="tblFestivos" class="tablas">
	<thead>
		<tr>
			<th>Opciones </th>
			<th>Nombre </th>
			<th>Fecha </th>
		</tr>
	</thead>
	<tbody>
	<?php
		
	foreach($festivos as $festivo){
		?>
		<tr id="<?= $festivo[0]?>">
			<td><a name="eliminar[]"  class= "icon-cancel"></a></td>
			<td  class=""><span name='nombre[]'><?= $festivo[1]?></span></td>
			<td> <span  name='mes[]' ><?= formatofecha($festivo[2])?></span></td>
		</tr>
		<?php
	}  
	?>
	</tbody>
</table>
<script>$.getScript("/js/festivos.js")</script>