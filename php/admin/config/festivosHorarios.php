<?php 
header('Content-Type: application/json');
include  "../../connect/conexion.php";
$conexion = conexion();

$sql = "SELECT * FROM horarios";
$row = mysqli_fetch_all(mysqli_query($conexion,$sql),MYSQLI_ASSOC);
$jd['horarios']=$row;

$sql="SELECT * FROM festivos";
$resultf = mysqli_query($conexion, $sql);
while ($rowf=mysqli_fetch_array($resultf)){
	$date =new DateTime($rowf['Fecha']);
	$date = date_format($date,"md");
	$jd['festivos'][]=$date;	
}
if(empty($jd['festivos']))$jd['festivos']=false;
echo json_encode($jd??"");