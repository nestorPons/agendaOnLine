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
				// 0 Id 1 Nombre 2 Email 3 Pass 4 Tel 5 Admin 6 Obs 7 Block 8 Baja 9 Activa 
				//10 datePass 11 cookie 12 Idioma 13 dateReg 14 dateBaja 
				include ('row.php');			
				
			}?>
		<tbody>
	</table>
</div> 