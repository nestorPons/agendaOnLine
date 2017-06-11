<?php
header('Content-Type: application/json');
require "../../connect/conexion.php";
$conexion = conexion();

$jsondata['success'] = false;
$id = $_POST["id"]??0;
if (empty($_POST["nombre"])){
	echo json_encode("ERROR NOMBRE");
	exit();
}
$nombre =$_POST["nombre"];
$email 	=trim($_POST["email"])??"";
$tel 		=trim($_POST['tel'])??"";
$obs		=trim($_POST['obs'])??"";
$admin 	= isset($_POST['admin'])?1:0;

$sql = 'SELECT dateBaja FROM usuarios WHERE Id = '. $id;
$result = mysqli_query($conexion,$sql);
$row = mysqli_fetch_row($result);


if(isset($_POST['activa'])){
	$fecha_baja = $row[0]==0?date("Y-m-d H:i:s"):$row[0];
}else{
	$fecha_baja ='NULL';	
}
$jsondata['fecha_baja'] = $fecha_baja;
if ($id==0){
	$sql="INSERT INTO usuarios (Nombre,Email,Tel,Obs,Admin) VALUE ('$nombre','$email','$tel','$obs',$admin)";
	if (mysqli_query($conexion,$sql)){
		$jsondata['id']=mysqli_insert_id($conexion);
		$jsondata['success'] = true;
		$id  = mysqli_insert_id($conexion);
		// 0 Id 1 Nombre 2 Email 3 Pass 4 Tel 5 Admin 6 Obs 7 Block 8 Baja 9 Activa 
		//10 datePass 11 cookie 12 Idioma 13 dateReg 14 dateBaja 
		$_SESSION['USUARIOS'][] = array($id, $nombre , $email , '' , $tel , $admin , $obs , 0 , 0 , 0 , 0 , 'es' , date("Y-m-d H:i:s") , 0);
	}	
}else{
	$sql = "UPDATE usuarios SET Nombre ='$nombre', Email ='$email', Tel ='$tel', Obs='$obs',dateBaja='$fecha_baja',Admin=$admin WHERE Id=$id";
	if (mysqli_query($conexion,$sql)){
		$jsondata['id']=mysqli_insert_id($conexion);
		$jsondata['success'] = true;
		foreach ( $_SESSION['USUARIOS'] as $key => $value ) {

			if ($id == $value[0] ){
				$key_id = $key ; 
				break;
			}

		}
		$_SESSION['USUARIOS'][$key_id] = array( $id , $nombre , $email ,$_SESSION['USUARIOS'][$key][4] , $tel , $admin , $obs , $_SESSION['USUARIOS'][$key][7] , $_SESSION['USUARIOS'][$key][8] , $_SESSION['USUARIOS'][$key][9] , $_SESSION['USUARIOS'][$key][10] , $_SESSION['USUARIOS'][$key][11] , $_SESSION['USUARIOS'][$key][12] ,$_SESSION['USUARIOS'][$key][13]  ,$_SESSION['USUARIOS'][$key][14] ) ;
	}


}

echo json_encode($jsondata);