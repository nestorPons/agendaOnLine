<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

	$sql = "SELECT C.Id, C.IdCita, D.Fecha, C.Hora , A.Descripcion, A.Codigo
					FROM cita C JOIN data D ON C.IdCita = D.IdCita 
					INNER JOIN usuarios U ON D.IdUsuario = U.Id 
					LEFT JOIN articulos A ON C.Servicio = A.Id  
					WHERE D.IdUsuario = ".  $_GET['user'] ." AND D.Fecha >= CURRENT_DATE() 
					ORDER BY D.Agenda, D.Fecha, C.Hora";		
	$result= mysqli_query($conexion,$sql);
	$data = mysqli_fetch_all($result,MYSQLI_NUM);

echo json_encode($data);			