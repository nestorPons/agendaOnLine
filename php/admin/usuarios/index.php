<?php 
	session_start();
	
?>
<div class="cabecera" >
	<?php include "../../../php/menus/menuABC.php" ?>
</div>	

<div class="cuerpo">
	<table class="tablas">					
		<thead>
			<tr>
				<th>Opcion</th>
				<th class="responsive">Num</th>
				<th>Nombre</th>
				<th>Telefono</th>
				<th>Email</th>
				<th class="responsive">Obs</th>
			</tr>
		<thead>
		<tbody>
			<?php 
			
			foreach($_SESSION['USUARIOS'] as $row){

				include ('row.php');			
				
			}?>
		<tbody>
	</table>
</div> 