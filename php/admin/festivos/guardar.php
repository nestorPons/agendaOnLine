<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$fecha = $_POST['fecha'];
$nombre = $_POST['nombre'];

$sql = "INSERT INTO festivos (fecha,nombre) VALUES ('$fecha','$nombre')";
$js['success'] = $conn->query($sql) ;

$js['id'] = $conn->id();
$js['nombre'] = $nombre;
$js['fecha']= $fecha;

echo json_encode($js);