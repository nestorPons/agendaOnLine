<?php 
header('Content-Type: application/json');
include "../../connect/conexion.php"; 
$conexion = conexion();

$n = (!empty($_GET['n']))?$_GET['n']:"";
//$sql="SELECT * FROM usuarios WHERE Nombre = $n";
//$row = mysqli_fetch_assoc(mysqli_query($conexion,$sql));
$data = $_SESSION['id_usuario'];
echo json_encode($data);
