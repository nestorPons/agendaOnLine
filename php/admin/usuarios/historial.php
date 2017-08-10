<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$fecha = Date('Y-m-d');

$d = $_GET['d']??1;
$t = $_GET['t']??'year';
$id = $_GET['id'];

$fchIni =date ( 'Y-m-d', strtotime ( '-'.$d.' '.$t , strtotime ( $fecha ) ) );

$sql = "SELECT C.Id, D.agenda, D.idCita, D.idUsuario, D.obs, C.hora , D.fecha , A.codigo 
FROM cita C JOIN data D ON C.idCita = D.idCita 
LEFT JOIN articulos A ON C.Servicio = A.Id  
WHERE idUsuario = $id AND D.fecha BETWEEN '$fchIni' AND '$fecha' 
ORDER BY D.fecha, D.agenda, C.hora"; 

$sql = preg_replace("/\r\n+|\r+|\n+|\t+/i", "", $sql);

echo json_encode($conn->all($sql));