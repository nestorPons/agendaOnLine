<?php session_start() ?>
<div class="cabecera">
	<?php include "../../../php/menus/menuABC.php"?>
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
				$id = $row[0];
				$email=empty($row[2])?"No":"Si";
				$Obs =empty($row[6])?"No":"Si";
				$clase_estado_baja = $row[14]!=0?'ocultar_baja':'';
				?>
				<tr id="rowUsuarios<?php echo $id?>" class="<?php echo $clase_estado_baja?>" data-value ="<?php echo$row[0]?>"> 
					<td class="w2"> 
						<span name="historia" class= "icon-doc-text x6 a" title="Historial de usuario"></span>
						<span name="editar[]" class= "icon-edit x6 a"  title="Editar usuario"></span>
					</td>
					<td name= "id" class="num responsive ">	<?php echo $id. " " ;?></td>
					<td name="nom" class="nom" id="<?php echo strtolower(str_replace(' ', '_', $row[1]))?>"><?php echo $row[1];?></td>
					<td name="tel" class="responsive"><?php echo $row[4];?></td>
					<td name="email" class="w1" data-value ="<?php echo$row[2]?>"><?php echo $email?></td>
					<td name="obs" class="obs responsive" data-value ="<?php echo$row[6]?>"><?php echo$Obs?></td>
					<td name="admin" class="hidden" data-value =<?php echo$row[5]?>></td>
	
				</tr><?php 
			}?>
		<tbody>
	</table>
</div> 