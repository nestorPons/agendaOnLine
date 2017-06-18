<?php 
	session_start();
	include "../../connect/tools.php";
?>
<div class="contenedorServicios">

	<?php include "../../../php/menus/servicios.php" ?>

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

				foreach($_SESSION['SERVICIOS'] as $row){
					
					include('row.php') ;

				}?>
			</tbody>
		</table>
	</div>
</div>