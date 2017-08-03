<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";


$id= $_POST['id']??"";
$id = intval(preg_replace('/[^0-9]+/', '', $id), 10);
$codigo = $_POST['codigo']??"";
$descripcion = trim($_POST['descripcion'])??"";
$tiempo =$_POST['tiempo']??0;
$precio =$_POST['precio']??0;
$familia =$_POST['familia']??0;
$tiempo = intval(preg_replace('/[^0-9]+/', '', $tiempo), 10);
$precio = intval(preg_replace('/[^0-9]+/', '', $precio), 10);

 if (!empty($id)){
	$nuevo = false ;
	$sql="UPDATE articulos SET Codigo = '$codigo',Descripcion ='$descripcion',Tiempo =$tiempo,Precio =$precio,IdFamilia =$familia , Baja = 0 WHERE Id = $id" ;
}else{
	$nuevo = true ;
	$sql = "SELECT * FROM articulos WHERE Codigo LIKE '$codigo'";

	if ($conn->num($result)<=0){
		$sql="INSERT INTO articulos (Codigo,Descripcion,Tiempo,Precio,IdFamilia) VALUE ('$codigo','$descripcion',$tiempo,$precio,$familia);";
	}else{
		$sql="UPDATE articulos SET Descripcion ='$descripcion',Tiempo =$tiempo,Precio =$precio,IdFamilia =$familia, Baja = 0 WHERE Codigo LIKE '$codigo'" ;
	}
}

if ($conn->query($sql)){
	
	$jsondata['codigo'] = $codigo;
	$jsondata['descripcion'] = $descripcion;
	$jsondata['tiempo'] = $tiempo;
	$jsondata['precio'] = $precio;
	$jsondata['familia'] = $familia;
	
	if($nuevo){
		//Nuevo 
		$jsondata['id'] = $conn->id();
		$_SESSION['SERVICIOS'][]  = array($jsondata['id'] , $codigo , $descripcion , $precio , $tiempo  , $familia, 0 ) ; 
	}else{
		//	0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
		//Editar 
		$jsondata['id'] = $id;
		foreach ( $_SESSION['SERVICIOS'] as $key => $value ) {

			if ($id == $value[0] ){
				$key_id = $key ; 
				break;
			}

		}	
		$_SESSION['SERVICIOS'][$key_id]  =  array( $id , $codigo , $descripcion , $precio , $tiempo  , $familia, $_SESSION['SERVICIOS'][$key_id][6] ) ; 
	}
	$jsondata['success'] = true;

}else{	
	$jsondata['success'] = false;
	$jsondata['sql'] = $sql;
 	$jsondata['error'] = $conn->error();
}	
echo json_encode($jsondata);