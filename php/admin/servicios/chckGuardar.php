<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$jsondata['success'] = true;
$id = preg_replace("/[^0-9-.]/", "", $_GET['id']);
$mostrar=$_GET['mostrar'];
$sql = "UPDATE familias SET Mostrar = $mostrar  WHERE IdFamilia = $id;";
if(!mysqli_query($conexion, $sql)){
	$jsondata['success'] = false;
}
echo json_encode($jsondata);
?>
