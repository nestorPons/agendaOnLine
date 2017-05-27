<?php session_start() ?>

<h1>Familias</h1>
<table class="tablas-mini">
	<thead>
		<tr>
			<th>Editar</th>
			<th>Nombre</th>
			<th>Mostrar a los clientes</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($_SESSION['FAMILIAS'] as $row){
			?>
			<tr  id="rowFamilias<?php echo $row[0]?>">
				<td>	<a class= "icon-edit" value="<?php echo $row[0]?>"></a></td>
				<td	id="nombre<?php echo $row[0]?>" ><?php echo$row[1]?></td>
				<td >
					<input id="chck<?php echo $row[0]?>" type='checkbox' name = 'mostrar[]' class="mostrar"
						value="<?php echo$row[0]?>"	<?php if ($row[2] ==1){ echo ' checked';}?>>
				</td>
			</tr>
			<?php
		}
		?>	
	</tbody>
</table>