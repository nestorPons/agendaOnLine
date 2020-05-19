
<div class="cabecera" >
	<?php include URL_MENUS . 'abc.php'  ?>
</div>	
<div class="cuerpo usuarios">
	<table class="tablas colorear-filas">					
		<thead>
			<tr class="row">
				<th class="botons">Opción</th>
				<th class="id">Id</th>
				<th class="tileName">Nombre</th>
				<th class="tileTel telefono">Teléfono</th>
				<th class="tileEmail email">Email</th>
				<th class="tileObs obs">Obs</th>
				<th class="tileAdmin admin">Admin</th>

			</tr>
		</thead>
		<tbody>
			<?php 
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
<scirpt src="js/min/usuarios.js"></scirpt>
<style>
	@media only screen and (max-width: 770px) {
		.usuarios .telefono, .usuarios .email, .usuarios .obs, .usuarios .admin{
			display: none;	
		}
		.usuarios .tileOpc{
			width: 10ch !important;
		}
	}
</style>