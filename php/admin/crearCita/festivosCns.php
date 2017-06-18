<?php 
header('Content-Type: application/json');
include  "../../connect/conexion.php";
$conexion = conexion();

$sql="SELECT * FROM festivos ;";
$cnsFestivos = mysqli_query($conexion, $sql);
while ($row=mysqli_fetch_array($cnsFestivos)){
	$date =new DateTime($row['Dia']."-".$row['Mes']."-".date("Y"));
	$date = date_format($date,"d-m-Y");
	$jd[]=$date;
}
echo json_encode($jd);
?>