
<div class="contenedorServicios">

	<?php require_once URL_MENUS. 'servicios.php'?>
	<div class="cuerpo">
		<table class = "tablas	">
			<thead>
				<tr>
					<th class="tileOpc">Opc</th>
					<th class="tileCod">Codigo</th>
					<th class="tileDes">Descripcion</th>
					<th class="tileTiem">Tiempo</i></th>
				</tr>	
			</thead>
			<tbody>
				<?php			
				$len = count($_SESSION['SERVICIOS']);
				for($i = 0; $i < $len ; $i++){
					$serv = $_SESSION['SERVICIOS'][$i];
					include URL_TEMPLATES . 'row.servicios.php';
				}?>
			</tbody>
		</table>
	</div>
</div>