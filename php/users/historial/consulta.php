<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

	$sql = "SELECT C.Id, C.idCita, D.fecha, C.hora , A.descripcion, A.codigo
					FROM cita C JOIN data D ON C.idCita = D.idCita 
					INNER JOIN usuarios U ON D.idUsuario = U.Id 
					LEFT JOIN articulos A ON C.Servicio = A.Id  
					WHERE D.idUsuario = ".  $_GET['user'] ." AND D.fecha >= CURRENT_DATE() 
					ORDER BY D.agenda, D.fecha, C.hora";		
	$result= mysqli_query($conexion,$sql);
	$data = mysqli_fetch_all($result,MYSQLI_NUM);

echo json_encode($data);			