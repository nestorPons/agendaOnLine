<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";	
$conexion = conexion();

$jsondata['success'] = false;
$id = $_POST['id'];
$nombre=trim($_POST['nombre']);
$mostrar=(!empty($_POST['mostrar']))?1:0;
$sql= ($id>=0)
	?$sql= "UPDATE Familias SET Nombre = '$nombre', Mostrar=$mostrar WHERE IdFamilia = $id"
	:$sql= "INSERT INTO familias (Nombre,Mostrar) VALUE ('$nombre',$mostrar)";
$jsondata['nombre'] = $nombre;
$jsondata['mostrar'] = $mostrar;
if(mysqli_query($conexion, $sql)){
	$jsondata['id'] = mysqli_insert_id($conexion);
	$jsondata['success'] = true;
}
echo json_encode($jsondata);