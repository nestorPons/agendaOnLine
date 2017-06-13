<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";	
$conexion = conexion();

$jsondata['success'] = false;
$id = $_POST['id'];
$nombre=trim($_POST['nombre']);
$mostrar=(!empty($_POST['mostrar']))?1:0;
$sql= ($id>=0)
	?$sql= "UPDATE Familias SET Nombre = '$nombre', Mostrar=$mostrar WHERE IdFamilia = $id"
	:$sql= "INSERT INTO familias (Nombre,Mostrar) VALUE ('$nombre',$mostrar)";
$jsondata['nombre'] = $nombre;
$jsondata['mostrar'] = $mostrar;
if(mysqli_query($conexion, $sql)){
// 0 IdFamilia 1 Nombre 2 Mostrar 
	$jsondata['id'] = mysqli_insert_id($conexion);
	$jsondata['success'] = true;
if($id>=0){

		foreach ( $_SESSION['FAMILIAS'] as $key => $value ) {

			if ($id == $value[0] ){
				$key_id = $key ; 
				break;
			}

		}	
		$_SESSION['FAMILIAS'][$key_id]  = array($id , $nombre , $mostrar ) ; 
	
}else{

	$_SESSION['FAMILIAS'][]  = array($jsondata['id'],$jsondata['nombre'],$jsondata['mostrar'] ); 
	
}

}
echo json_encode($jsondata);