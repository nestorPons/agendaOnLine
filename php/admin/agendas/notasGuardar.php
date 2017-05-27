<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$id = $_GET['id'];
$txt = $_GET['txt'];
$sql = "UPDATE data SET Obs='$txt' WHERE IdCita=$id;";
$data['success']=mysqli_query($conexion,$sql)?true:false;
echo json_encode($data);