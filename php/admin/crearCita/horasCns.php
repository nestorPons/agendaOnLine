<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$sql="SELECT C.Hora FROM cita C JOIN data D ON C.IdCita = D.IdCita WHERE D.Fecha  = '".$_GET['f']."' AND Agenda = ".$_GET['a'];
$result	= mysqli_query($conexion,$sql);
$datos['horas'] = mysqli_fetch_all($result, MYSQLI_NUM);
$datos['fecha'] = $_GET['f'];
echo json_encode($datos);