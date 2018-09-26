<table class="tablas colorear-filas">
	<thead>
		<tr>
			<th>Editar</th>
			<th>nombre</th>
			<th>Mostrar a los clientes</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($_SESSION['FAMILIAS'] as $row){
			// 0 IdFamilia 1 nombre 2 Mostrar 3 Baja
			$class =  ($row[3] == 1 )?'ocultar_baja':'';
				?>
				<tr  id="rowFamilias<?= $row[0]?>" class='<?=$class ?>'>
					<td> <a class= "icon-edit" value="<?= $row[0]?>"></a></td>
					<td	id="familia_<?=$row[0]?>" class="nombre" ><?=$row[1]?></td>
					<td >
						<input id="chck<?= $row[0]?>" type='checkbox' name = 'mostrar[]' class="mostrar"
							value="<?=$row[0]?>" <?php if ($row[2] ==1){ echo ' checked';}?>>
					</td>
				</tr>
			<?php
		}
		?>	
	</tbody>
</table>
<scirpt src="js/min/familias.js"></scirpt>