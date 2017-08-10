<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$nota = $_POST['notas'];
$arrayfecha =explode('/', $_POST['datepicker'] );
$fecha = $arrayfecha[2]. "-". $arrayfecha[1] . "-". $arrayfecha[0];
$sql="SELECT * FROM notas WHERE fecha = '$fecha'";
$row	= mysqli_fetch_array(mysqli_query($conexion,$sql));
$SQL= $row['fecha']!=""
?"UPDATE notas SET Nota  ='$nota' WHERE fecha = '$fecha';"
:"INSERT INTO notas (Id,Nota,fecha) VALUE	('','$nota','$fecha')";	
$jsondata['sql'] = $SQL;
$jsondata['success'] =(mysqli_query($conexion,$SQL))?true:false;
echo json_encode($jsondata);