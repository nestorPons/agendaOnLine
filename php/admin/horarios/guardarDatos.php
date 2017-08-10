<?php 
require "../../connect/conexion.php";
$conexion = conexion();

function format($fecha){
	$Arrayfecha =explode('/', $fecha );
	$fecha= $Arrayfecha[1].$Arrayfecha[0];
	return $fecha;
}
$js['ini'] = format($_POST['fechaIni']);
$js['fin'] = format($_POST['fechaFin']);
$js['nombre'] =$_POST['nom'];
$js['id']=$_POST['id'];
$sql= "UPDATE horarios SET nombre= '".$_POST['nom']."', fechaIni = '".$js['ini']."',fechaFin = '".$js['fin']."' WHERE Id =". $_POST['id'];
$js['sql']=($sql);
$js['success']=(mysqli_query($conexion,$sql))?true:false;
echo json_encode($js);