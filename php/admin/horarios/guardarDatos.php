<?php 
require "../../connect/conexion.php";
$conexion = conexion();

function format($fecha){
	$ArrayFecha =explode('/', $fecha );
	$fecha= $ArrayFecha[1].$ArrayFecha[0];
	return $fecha;
}
$js['ini'] = format($_POST['fechaIni']);
$js['fin'] = format($_POST['fechaFin']);
$js['nombre'] =$_POST['nom'];
$js['id']=$_POST['id'];
$sql= "UPDATE horarios SET Nombre= '".$_POST['nom']."', FechaIni = '".$js['ini']."',FechaFin = '".$js['fin']."' WHERE Id =". $_POST['id'];
$js['sql']=($sql);
$js['success']=(mysqli_query($conexion,$sql))?true:false;
echo json_encode($js);