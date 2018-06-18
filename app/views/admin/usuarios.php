
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
					<th class="tel">Telefono</th>
					<th class="email">Email</th>
					<th class="obs">obs</th>
					<th class="admin">admin</th>
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
				$id = $user['id'] ;
				$nombre = $user['nombre'] ; 
				$email = $user['email'] ; 
				$tel = $user['tel'] ; 
				$admin = $user['admin'] ; 
				$obs = $user['obs'] ; 
				$activa = $user['status'] ; 
				$email_status= empty($email)?"No":"Si";
				$obs_status =empty($obs)?"No":"Si";
				$clase = empty($user['dateBaja'])?'':'ocultar_baja';

				include (URL_TEMPLATES .'row.users.php');			
				
			}?>
		</tbody>
	</table>
</div> 