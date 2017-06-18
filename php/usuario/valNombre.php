<?php
header('Content-Type: application/json'); 
require('connect/conexion.php');
$conexion = conexion( $security=false,$bd=$_POST['empresa']);

$sql = "SELECT Id FROM usuarios WHERE Nombre = '".$_POST['nombre']."';";
$result = mysqli_query($conexion,$sql);
$data= mysqli_num_rows($result);
echo json_encode($data);