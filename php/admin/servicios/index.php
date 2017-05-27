<?php 
	session_start();
	include "../../connect/tools.php";
?>
<div class="contenedorServicios">

	<?php include "../../../php/menus/servicios.php"?>

	<div class="cuerpo">
		<table class = "tablas">
			<thead>
				<tr>
					<th>Opc<span class="responsive">iones</span></th>
					<th>Codigo </th>
					<th>Descripcion</th>
					<th><i class="icon-clock"></i></th>
				</tr>	
			</thead>
			<tbody>
				<?php

				$n = 0 ;
				foreach($_SESSION['SERVICIOS'] as $row){
					$n++;
					$ini_familia = $n==1 ?   $row[5]  : $ini_familia;
					// 0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
					?>
					<tr id="rowServicios<?php echo $row[0]?>" 
					class="fam<?php echo$row[5]?> <?php echo $row[5] == $ini_familia ? "" : "disabled"; ?>"  
					name="<?php echo normaliza($row[1])?>" 
					familia = "<?php echo$row[5]?>"
					value=<?php echo $row[0]?> >
						<td class="ico"><a name="editar[]" class= "icon-edit x6" value="<?php echo $row[0]?>"></a></td>
						<td name='cod' class='aling-left cod'><?php echo $row[1]?></td>
						<td name='des' class="nom"><?php echo $row[2]?> </td>
						<td name='time' class ="ico" ><?php echo $row[4]?></td>
						<td name='price' class="hidden" data-value=<?php echo $row[3]?>></td>
					</tr><?php
				}?>
			</tbody>
		</table>
	</div>
</div>