<?php
include_once "../../connect/conexion.php";
echo "<h2>Ultima actualización: " . date("d-m-Y H:i:s")."</h2>";
 ?>
<table class = "tablas">
		<tr class="encabezado">
			<td class="50px responsive">Id</td>
			<td class="100px">Usuario</td>
			<td class="100px">Evento</td>
			<td class="50px">Hora</td>
			<td class="50px">Fecha</td>
			<td class="50px">Id cita</td>
		</tr>	
<?php
$SQL ="SELECT  even.* , eventos.Nombre as evenNom, usuarios.Nombre as userNom 
				FROM (even INNER JOIN eventos ON even.IdEven = eventos.IdEven)   
				INNER JOIN usuarios
				ON even.IdUsuario = usuarios.Id
				ORDER BY even.Id DESC 
				LIMIT 50";
$result= mysqli_query($conexion,$SQL);
while($row = mysqli_fetch_array($result)){
	$eventoClick="";
	if ($row['IdEven']==1){
		$color=  " style='color:green'";
		$agenda = $row['agenda'];
		$id = $row['IdCita'];
		$sql = "SELECT * FROM cita$agenda WHERE IdCita=$id";
		
		$resultCita= mysqli_query($conexion,$sql);
		$rowCita = mysqli_fetch_array($resultCita);
		$fechaCita = $rowCita['Fecha'];
		$arrayFech = explode('-',$fechaCita);
		$fechaCita = $arrayFech[2] ."/".$arrayFech[1] ."/".$arrayFech[0] ;
		$eventoClick = "window.location.href='/agenda/admin/agendas/agenda$agenda.php?fecha=$fechaCita'";
	}elseif ($row['IdEven']==2){
		$color=  " style='color:red'";
	}else{
		$color=  "";
	};
	$ArrayFecha =explode(' ', $row['Fecha'] );
	$hora =  $ArrayFecha[1];
	$fch = $ArrayFecha[0];
	$arrayFech = explode('-',$fch);
	$fecha = $arrayFech[2] ."/".$arrayFech[1] ."/".$arrayFech[0] ;
	if (!empty($row['IdCita'])){
		$class = "class='raton resaltar'";
	}else{
		$class="";
	}
	?>
	<tr <?php echo $color?> 
		onclick="<?php echo$eventoClick?>"
		<?php echo$class?>	> 
			<td class=" responsive"><?php echo  $row['Id']?></td>
			<td ><?php echo  $row['userNom'] ?></td>
			<td ><?php echo  $row['evenNom'] ?></td>
			<td><?php echo  $hora ?></td>
			<td ><?php echo  $fecha?></td>
			<td><?php echo $row['IdCita']?></td>
	</tr>
	<?php 
}
?>
</table>