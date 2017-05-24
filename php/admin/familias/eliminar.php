<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$id=$_GET['id'];
$sql = "DELETE FROM familias WHERE IdFamilia = $id;";
$sql.= "UPDATE articulos SET Baja=1 WHERE IdFamilia = $id";
$return['success'] = mysqli_multi_query($conexion, $sql);

echo json_encode($return);