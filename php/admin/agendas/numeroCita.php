<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$fecha = $_GET['fecha'];
$dias = $_GET['margen'];
$fchIni =date ( 'Y-m-d', strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) );
$fchFin =date ( 'Y-m-d', strtotime ( '-'.$dias.' day' , strtotime ( $fecha ) ) );

$sql = "SELECT C.Id, A.Codigo, D.Agenda, D.IdCita, D.IdUsuario, U.Nombre, D.Obs, C.Hora , D.Fecha ,A.Tiempo
	FROM cita C JOIN data D ON C.IdCita = D.IdCita 
	INNER JOIN usuarios	U ON D.IdUsuario = U.Id 
	LEFT JOIN articulos A ON C.Servicio = A.Id  
	WHERE D.Fecha BETWEEN '$fchFin'  AND '$fchIni'  
	ORDER BY D.Fecha, D.Agenda, C.Hora";

$result=mysqli_query($conexion,$sql);
$data=mysqli_fetch_all($result,MYSQLI_ASSOC);

echo json_encode($data);