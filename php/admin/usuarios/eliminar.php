<?php
header('Content-Type: application/json');
include "../../connect/conexion.php"; 
$conexion = conexion();

$sql="UPDATE  usuarios SET dateBaja = '". date('Y-m-d H:m:s') ."' WHERE Id =".$_GET['id'];
$jsondata['sql'] = $sql;
$jsondata['success'] =mysqli_query($conexion, $sql)?true:false;
//registrarEvento(2,0, $_GET['id'],0);
echo json_encode($jsondata);