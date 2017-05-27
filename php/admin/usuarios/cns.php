<?php 
header('Content-Type: application/json');
include "../../connect/conexion.php"; 
$conexion = conexion();

$idUsuario = (!empty($_GET['id']))?$_GET['id']:1;
$sql="SELECT * FROM usuarios WHERE Id =$idUsuario WHERE Baja =0 ";
$row = mysqli_fetch_array(mysqli_query($conexion,$sql));
$jd['id']=$row['Id'];
$jd['nombre']=$row['Nombre'];
$jd['email']=$row['Email'];
$jd['tel']=$row['Tel'];
$jd['obs']=$row['Obs'];
$jd['chk']=$row['activa']==1?true:false;
$jd['admin']=$row['Admin']==1?true:false;
echo json_encode($jd);