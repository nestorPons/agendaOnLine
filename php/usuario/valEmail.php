<?php
header('Content-Type: application/json'); 
require('../../connect/conexion.php');
$conexion = conexion( $security=false,$bd=$_POST['empresa']);

$sql = "SELECT Id FROM usuarios WHERE Email = '".$_POST['email']."';";
$data= ($result = mysqli_query($conexion,$sql))?mysqli_num_rows($result):0;
echo json_encode($data);