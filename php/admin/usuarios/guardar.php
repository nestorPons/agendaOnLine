<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$jsondata['success'] = false;
$id = $_POST["id"]??0;
if (empty($_POST["nombre"])){
	echo json_encode("ERROR NOMBRE");
	exit();
}
$nombre =$_POST["nombre"];
$email 	=trim($_POST["email"])??"";
$tel 		=trim($_POST['tel'])??"";
$obs		=trim($_POST['obs'])??"";
$admin 	= isset($_POST['admin'])?1:0;

$sql = 'SELECT dateBaja FROM usuarios WHERE Id = '. $id;
$result = mysqli_query($conexion,$sql);
$row = mysqli_fetch_row($result);
if(isset($_POST['activa'])){
	$fecha_baja = $row[0]==0?date("Y-m-d H:i:s"):$row[0];
}else{
	$fecha_baja ='NULL';	
}
$jsondata['fecha_baja'] = $fecha_baja;
if ($id==0){
	$sql="INSERT INTO usuarios (Nombre,Email,Tel,Obs,Admin) VALUE ('$nombre','$email','$tel','$obs',$admin)";
}else{
	$sql = "UPDATE usuarios SET Nombre ='$nombre', Email ='$email', Tel ='$tel', Obs='$obs',dateBaja='$fecha_baja',Admin=$admin WHERE Id=$id";
}
if (mysqli_query($conexion,$sql)){
	$jsondata['id']=mysqli_insert_id($conexion);
	$jsondata['success'] = true;
}
echo json_encode($jsondata);