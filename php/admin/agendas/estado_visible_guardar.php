<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$sql = "UPDATE config SET ShowRow = ".$_GET['status'];
$data['success']=mysqli_query($conexion,$sql);
echo json_encode($data);