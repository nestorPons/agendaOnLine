<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$id = $_POST['id'];
$nombre=trim($_POST['nombre']);
$mostrar=(!empty($_POST['mostrar']))?1:0;

$sql= ($id>=0)
	?$sql= "UPDATE familias SET nombre = '$nombre', Mostrar = $mostrar , Baja = 0 WHERE IdFamilia = $id"
	:$sql= "INSERT INTO familias (nombre,Mostrar) VALUE ('$nombre',$mostrar)";

$jsondata['nombre'] = $nombre;
$jsondata['mostrar'] = $mostrar;

if($conn->query($sql)){
// 0 IdFamilia 1 nombre 2 Mostrar 3 baja
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

		$jsondata['id'] = $conn->id($conexion);
		$_SESSION['FAMILIAS'][]  = array($jsondata['id'] , $jsondata['nombre'] , $jsondata['mostrar'] , 0 ); 
		
	}

}else{

	$jsondata['success'] = false;
	$jsondata['err'] = $conn->error($conexion);
	$jsondata['err_num'] = $conn->errno($conexion);

}
echo json_encode($jsondata);