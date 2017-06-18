<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$fecha = Date('Y-m-d');

$d = $_GET['d']??1;
$t = $_GET['t']??'year';
$id = $_GET['id'];

$fchIni =date ( 'Y-m-d', strtotime ( '-'.$d.' '.$t , strtotime ( $fecha ) ) );

$sql = "SELECT C.Id, D.Agenda, D.IdCita, D.IdUsuario, D.Obs, C.Hora , D.Fecha , A.Codigo 
FROM cita C JOIN data D ON C.IdCita = D.IdCita 
LEFT JOIN articulos A ON C.Servicio = A.Id  
WHERE IdUsuario = $id AND D.Fecha BETWEEN '$fchIni' AND '$fecha' 
ORDER BY D.Fecha, D.Agenda, C.Hora"; 

$sql = preg_replace("/\r\n+|\r+|\n+|\t+/i", "", $sql);

$result= mysqli_query($conexion,$sql);
$js = mysqli_fetch_all($result,MYSQLI_ASSOC)??false;

echo json_encode($js);