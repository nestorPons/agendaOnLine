<?php
header('Content-Type: application/json'); 
include "../../connect/conexion.php";
$conexion = conexion();

$idUsuario = trim($_SESSION['id_usuario'])??null;
$oldPass = trim($_POST['a'])??"";
$sql = "SELECT Id FROM usuarios WHERE Id  =  $idUsuario AND Pass ='$oldPass'";
$result = mysqli_query($conexion,$sql);
$return = (mysqli_num_rows($result)!=0);
echo json_encode($return);