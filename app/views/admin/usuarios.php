
<div class="cabecera" >
	<?php include URL_TEMPLATES . 'menus/abc.php'  ?>
</div>	
<div class="cuerpo">
	<table class="tablas colorear-filas">					
		<thead>
			<tr>
				<th class="tileOpc">Opcion</th>
				<th class="tileId">Id</th>
				<th class="tileName">Nombre</th>
				<?php if(!$Device->isMobile()){?>
					<th class="tileTel">Teléfono</th>
					<th class="tileEmail">Email</th>
					<th class="tileObs">Obs</th>
					<th class="tileAdmin">Admin</th>
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
			$status = 0;
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
				$color = $user['color'] ;
				$status = $user['status'] ; 
				$email_status= empty($email)?"No":"Si";
				$obs_status =empty($obs)?"No":"Si";
				$clase = empty($user['dateBaja'])?'':'ocultar_baja';

				include (URL_TEMPLATES .'row.users.php');			
				
			}?>
		</tbody>
	</table>
</div> 