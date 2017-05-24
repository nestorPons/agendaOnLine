<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$id = $_GET['id'];
$sql = "DELETE FROM festivos WHERE Id =".$id;
$js['sql'] = $sql;
$js['success'] =mysqli_query($conexion,$sql)?true:false;
echo json_encode($js);