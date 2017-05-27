<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$sql='UPDATE articulos  SET Baja = 1 WHERE id='.$_GET['id'];;
$jsondata['success'] =mysqli_query($conexion, $sql);

echo json_encode($jsondata);