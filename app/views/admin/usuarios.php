
<div class="cabecera" >
	<?php include URL_TEMPLATES . 'menus/abc.php'  ?>
</div>	
<div class="cuerpo">
	<table class="tablas">					
		<thead>
			<tr>
				<th>Opcion</th>
				<th class="num">Num</th>
				<th class="name">nombre</th>
				<?php if(!$Device->isMovile){?>
					<th>Telefono</th>
					<th>Email</th>
					<th>obs</th>
					<th>admin</th>
					<?php
				}?>	
			</tr>
		</thead>
		<tbody>
			<?php 
			//template para js 
			$id = '' ;
			$nombre = '' ; 
			$email = '' ; 
			$tel = '' ; 
			$admin = '' ; 
			$obs = '' ; 
			$activa = '' ; 
			$email_status= '';
			$obs_status = '';
			$clase = 'template';
			include (URL_TEMPLATES .'row.users.php');			
			//****//

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
				$clase = $activa!=0||!empty($user[9])?'ocultar_baja':'';

				include (URL_TEMPLATES .'row.users.php');			
				
			}?>
		</tbody>
	</table>
</div> 