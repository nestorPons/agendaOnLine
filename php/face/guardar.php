<?php
$validar=true;
include "connect/conexion.php";
$conexion = conexion();

$nombre=$_GET['nombre'];
$email = $_GET['email'];
$id= $_GET['id'];
if ($email=="undefined"){
		header ("location:../index.php");
}else{
	$sql="INSERT INTO usuarios (Id,nombre,Email,Pass,Tel,Admin,obs) VALUE ('','$nombre','$email','','','0','$id');";
	mysqli_query($conexion,$sql);
	$sql="SELECT * FROM usuarios WHERE Email = '$email'";
	$result=mysqli_query($conexion,$sql);
	$row = mysqli_fetch_array($result);
	if(isset($row)){
		registrarEvento(3,0,$row["Id"],0); 
		header("location:validar.php?nombre=$nombre&email=$email&id=$id");
	}else{
		echo "Error al guardar el usuario";
	}
}

