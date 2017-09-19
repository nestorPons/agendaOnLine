
<div class="cabecera" >
	<?php include URL_TEMPLATES . 'menus/abc.php'  ?>
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
			
			foreach($users as $user){
				$id = $user[0] ;
				$nombre = $user[1] ; 
				$email = $user[2] ; 
				$tel = $user[4] ; 
				$admin = $user[5] ; 
				$obs = $user[6] ; 
				$activa = $user[10] ; 
				$email_status= empty($email)?"No":"Si";
				$obs_status =empty($obs)?"No":"Si";
				$clase_estado_baja = $activa!=0?'ocultar_baja':'';

				include (URL_TEMPLATES .'row.users.php');			
				
			}?>
		<tbody>
	</table>
</div> 