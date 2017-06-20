<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$id = $_POST['id'];
$a = $_POST['agenda'] ; 
$user = $_POST['nombre'];
$note = $_POST['notas'];

$sql = "
UPDATE IdCita$a
SET Nombre='$user', Obs='$note'
WHERE IdCita=$id;
";
if(mysqli_query($conexion, $sql)){
	$jsondata['success'] = true;
	registrarEvento(2, $id, $user, $agenda);
}else{
	$jsondata['success'] = false;
}
$jsondata['registros'] = mysqli_affected_rows($conexion);
echo json_encode($jsondata);
?>