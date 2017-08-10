
<div class="contenedorServicios">

	<?php include $_SERVER['DOCUMENT_ROOT']."/php/menus/servicios.php" ?>
	<div class="cuerpo">
		<table class = "tablas	">
			<thead>
				<tr>
					<th>Opc<span class="responsive">iones</span></th>
					<th>codigo </th>
					<th>descripcion</th>
					<th><i class="icon-clock"></i></th>
				</tr>	
			</thead>
			<tbody>
				<?php
				
				foreach($_SESSION['SERVICIOS'] as $row){
					
					include('servicios/row.php') ;

				}?>
			</tbody>
		</table>
	</div>
</div>