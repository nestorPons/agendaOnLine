<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";
$conexion = conexion();

$id= $_POST['id']??"";
$id = intval(preg_replace('/[^0-9]+/', '', $id), 10);
$codigo = $_POST['codigo']??"";
$descripcion = trim($_POST['descripcion'])??"";
$tiempo =$_POST['tiempo']??0;
$precio =$_POST['precio']??0;
$familia =$_POST['familia']??0;
$tiempo = intval(preg_replace('/[^0-9]+/', '', $tiempo), 10);
$precio = intval(preg_replace('/[^0-9]+/', '', $precio), 10);
$sql= (!empty($id))
	?"UPDATE articulos SET Codigo = '$codigo',Descripcion ='$descripcion',Tiempo =$tiempo,Precio =$precio,IdFamilia =$familia WHERE Id = $id"
	:"INSERT INTO articulos (Codigo,Descripcion,Tiempo,Precio,IdFamilia) VALUE ('$codigo','$descripcion',$tiempo,$precio,$familia);";
if (mysqli_query($conexion,$sql)){
	$sql="SELECT Id FROM articulos WHERE Codigo LIKE '$codigo';";
	$datos = mysqli_fetch_assoc(mysqli_query($conexion,$sql));
	$jsondata['id'] = $datos['Id'];
	$jsondata['codigo'] = $codigo;
	$jsondata['descripcion'] = $descripcion;
	$jsondata['tiempo'] = $tiempo;
	$jsondata['precio'] = $precio;
	$jsondata['familia'] = $familia;
	$jsondata['success'] = true;
}else{	
	$jsondata['success'] = false;
}	
echo json_encode($jsondata);