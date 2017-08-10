
<div class="cabecera" >
	<?php include ($_SERVER['DOCUMENT_ROOT'].'/php/menus/menuABC.php') ?>
</div>	

<div class="cuerpo">
	<table class="tablas">					
		<thead>
			<tr>
				<th>Opcion</th>
				<th class="responsive">Num</th>
				<th>nombre</th>
				<th>Telefono</th>
				<th>Email</th>
				<th class="responsive">obs</th>
			</tr>
		<thead>
		<tbody>
			<?php 
			
			foreach($_SESSION['USUARIOS'] as $row){

				include ('usuarios/row.php');			
				
			}?>
		<tbody>
	</table>
</div> 