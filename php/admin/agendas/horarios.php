<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();
$sql = "SELECT * FROM horarios";
$row = mysqli_fetch_all(mysqli_query($conexion,$sql),MYSQLI_ASSOC);
echo json_encode($row);