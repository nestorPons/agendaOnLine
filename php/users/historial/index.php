<table id="tableHistory" class="tablas-group">
<?php
	$sql = 'SELECT C.Id, C.IdCita, D.Fecha, C.Hora , A.Descripcion, C.Servicio
					FROM cita C JOIN data D ON C.IdCita = D.IdCita 
					INNER JOIN usuarios U ON D.IdUsuario = U.Id 
					LEFT JOIN articulos A ON C.Servicio = A.Id  
					WHERE D.IdUsuario = '.  $_SESSION['id_usuario'] .' AND D.Fecha >= CURRENT_DATE() 
					GROUP BY C.IdCita, C.Id 		
					ORDER BY D.Agenda, D.Fecha, C.Hora';
					
	$result= mysqli_query($conexion,$sql);
	$data = mysqli_fetch_all($result,MYSQLI_NUM);

	$servicio_anterior=0;
	$fecha_anterior=0;
	foreach($data as  $clave => $valor){
		$date = new DateTime($valor[2]);

		if ($servicio_anterior!=$valor[5]){
			?>
			<tr id="tr<?php echo $valor[0]?>" 
				class="<?php echo $valor[1].$valor[5]?>" 
				idCita="<?php echo $valor[1]?>" 
				idser=<?php echo$valor[5]?> 
				data-fecha="<?php echo $valor[2]?>" 
				data-hora='<?php echo$valor[3]?>'>
				<td id='<?php echo$valor[0]?>'>
					<i class="icon-cancel"></i>
					<i class="icon-load c5 animate-spin hidden"></i>
				</td>
				<td class="padding5 "><?php echo date_format($date,"d/m/Y")?> a las <?php echo HORAS[$valor[3]]?></td>
				<td class="padding5 aling-left"><?php echo$valor[4]?></td> 
			</tr>
			<?php
		}
		$servicio_anterior = $valor[5];
	}
?>
</table>