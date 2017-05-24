<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$fecha = $_POST['fecha'];
$nombre = $_POST['nombre'][0];
$array = explode('/',$fecha);
$fecha = $array[2]."-".$array[1]."-".$array[0];
$sql = "INSERT INTO festivos (Fecha,Nombre) VALUES ('$fecha','$nombre')";
$js['success'] = mysqli_query($conexion,$sql)?true:false;
$js['id'] = mysqli_insert_id($conexion);
$js['nombre'] = $nombre;
$js['fecha']= $fecha;
echo json_encode($js);