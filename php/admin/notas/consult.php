<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$sql = "SELECT Fecha, Nota FROM notas";
$result	= mysqli_query($conexion,$sql);
$array = mysqli_fetch_all($result, MYSQLI_NUM);
foreach ($array as $clave => $valor){
	$datos[$valor[0]]=$valor[1];
}
echo json_encode($datos);