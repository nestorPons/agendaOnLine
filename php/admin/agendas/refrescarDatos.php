<?php 
header('Content-Type: application/json');
require_once "../../connect/conexion.php";
$conexion = conexion();
	
$sql = 'SELECT *	FROM cita_user'; //id idCita status

$result=mysqli_query($conexion,$sql);
$data = mysqli_fetch_all($result,MYSQLI_ASSOC);

echo json_encode($data);