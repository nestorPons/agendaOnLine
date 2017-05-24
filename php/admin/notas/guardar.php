<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$nota = $_POST['notas'];
$arrayFecha =explode('/', $_POST['datepicker'] );
$fecha = $arrayFecha[2]. "-". $arrayFecha[1] . "-". $arrayFecha[0];
$sql="SELECT * FROM notas WHERE Fecha = '$fecha'";
$row	= mysqli_fetch_array(mysqli_query($conexion,$sql));
$SQL= $row['Fecha']!=""
?"UPDATE notas SET Nota  ='$nota' WHERE fecha = '$fecha';"
:"INSERT INTO notas (Id,Nota,Fecha) VALUE	('','$nota','$fecha')";	
$jsondata['sql'] = $SQL;
$jsondata['success'] =(mysqli_query($conexion,$SQL))?true:false;
echo json_encode($jsondata);