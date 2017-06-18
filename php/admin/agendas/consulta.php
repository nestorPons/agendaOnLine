<?php namespace admin\agendas;

function consulta($fecha){
	global $conexion;
	
	$sql = 'SELECT C.Id, D.IdCita,  D.Fecha , C.Hora ,D.IdUsuario, U.Nombre, A.Id AS IdCodigo, A.Codigo, A.Tiempo , D.Agenda,  D.Obs 
	FROM cita C JOIN data D ON C.IdCita = D.IdCita 
	INNER JOIN usuarios U ON D.IdUsuario = U.Id 
	LEFT JOIN articulos A ON C.Servicio = A.Id 
	WHERE D.Fecha ="'.$fecha.'"  
	ORDER BY D.Fecha, D.Agenda, C.IdCita';

	$sql = preg_replace("/\r\n+|\r+|\n+|\t+/i", "", $sql);

	$result=mysqli_query($conexion,$sql);
	return mysqli_fetch_all($result,MYSQLI_NUM);
}
