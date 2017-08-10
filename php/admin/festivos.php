<h1>Festivos</h1>

<table id="tblFestivos" class="tablas">
	<tr>
		<th>Opc </th>
		<th>nombre </th>
		<th>fecha </th>
	</tr>
	<?php
	$festivos= $conn->all("SELECT * FROM festivos ORDER BY ID ASC") ; 
	
	foreach($festivos as $festivo){
		?>
		<tr id="<?= $festivo[0]?>">
			<td><a name="eliminar[]"  class= "icon-cancel c5 x6"></a></td>
			<td  class="aling-left"><span name='nombre[]'><?= $festivo[1]?></span></td>
			<td> <span  name='mes[]' ><?= formatofecha($festivo[2])?></span></td>
		</tr>
		<?php
	}  
	?>
</table>