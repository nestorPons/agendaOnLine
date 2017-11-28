
<div class="contenedorServicios">

	<?php require_once URL_MENUS. 'servicios.php'?>
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
				foreach($_SESSION['SERVICIOS'] as $key => $serv){

					require URL_TEMPLATES . 'row.servicios.php';

				}?>
			</tbody>
		</table>
	</div>
</div>