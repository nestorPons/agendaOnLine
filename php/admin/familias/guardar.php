<?php
header('Content-Type: application/json');
include "../../connect/conexion.php";	
$conexion = conexion();

$id = $_POST['id'];
$nombre=trim($_POST['nombre']);
$mostrar=(!empty($_POST['mostrar']))?1:0;

$sql= ($id>=0)
	?$sql= "UPDATE familias SET Nombre = '$nombre', Mostrar = $mostrar , Baja = 0 WHERE IdFamilia = $id"
	:$sql= "INSERT INTO familias (Nombre,Mostrar) VALUE ('$nombre',$mostrar)";

$jsondata['nombre'] = $nombre;
$jsondata['mostrar'] = $mostrar;

if(mysqli_query($conexion, $sql)){
// 0 IdFamilia 1 Nombre 2 Mostrar 3 baja
	$jsondata['success'] = true;

	if($id>=0){
			$jsondata['id'] = $id ;
			foreach ( $_SESSION['FAMILIAS'] as $key => $value ) {

				if ($id == $value[0] ){
					$key_id = $key ; 
					break;
				}

			}	
			$_SESSION['FAMILIAS'][$key_id]  = array($id , $nombre , $mostrar, 0 ) ; 
		
	}else{

		$jsondata['id'] = mysqli_insert_id($conexion);
		$_SESSION['FAMILIAS'][]  = array($jsondata['id'] , $jsondata['nombre'] , $jsondata['mostrar'] , 0 ); 
		
	}

}else{

	$jsondata['success'] = false;
	$jsondata['err'] = mysqli_error($conexion);
	$jsondata['err_num'] = mysqli_errno($conexion);

}
echo json_encode($jsondata);