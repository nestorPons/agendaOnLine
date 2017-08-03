<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$jsondata['success'] = false;
$id = $_POST["id"]??0;
if (empty($_POST["nombre"])){
	echo json_encode("ERROR NOMBRE");
	exit();
}
$nombre =$_POST["nombre"];
$email 	=trim($_POST["email"])??"";
$tel 	=trim($_POST['tel'])??"";
$obs	=trim($_POST['obs'])??"";
$admin 	= isset($_POST['admin'])?1:0;
$block 	= isset($_POST['activa'])?1:0;

$row = $conn->row('SELECT dateBaja FROM usuarios WHERE Id = '. $id . ' LIMIT 1')[0];

$fecha_baja = (isset($_POST['activa']))
	? $row==0?date("Y-m-d H:i:s"):$row
	: $fecha_baja ='NULL';	

$jsondata['fecha_baja'] = $fecha_baja;
if ($id==0){
	$result=$conn->query("INSERT INTO usuarios (Nombre,Email,Tel,Obs,Admin) VALUE ('$nombre','$email','$tel','$obs',$admin)");
	if ($result){
		$id  = $conn->id();
		$jsondata['id']= $id;
		$jsondata['success'] = true;
		// 0 Id 1 Nombre 2 Email 3 Pass 4 Tel 5 Admin 6 Obs 7 cookie 8 Idioma 9 dateReg 10 dateBaja 11 Block
		$_SESSION['USUARIOS'][] = array($id, $nombre , $email , '' , $tel , $admin , $obs , 0 , 0 , 0 , 0 , 'es' , date("Y-m-d H:i:s") , 0);
	}	
}else{
	$result=$conn->query( "UPDATE usuarios SET Nombre ='$nombre', Email ='$email', Tel ='$tel', Obs='$obs',dateBaja='$fecha_baja', Admin=$admin , Block=$block WHERE Id=$id");
	if ($result){
		$jsondata['id']= $id ;
		$jsondata['success'] = true ;
		foreach ( $_SESSION['USUARIOS'] as $key => $value ) {

			if ($id == $value[0] ){
				$key_id = $key ; 
				break;
			}

		}
		// 0 Id 1 Nombre 2 Email 3 Pass 4 Tel 5 Admin 6 Obs 7 cookie 8 Idioma 9 dateReg 10 dateBaja 11 block
		$_SESSION['USUARIOS'][$key_id] = array( $id , $nombre , $email ,$_SESSION['USUARIOS'][$key][4] , $tel , $admin , $obs , $_SESSION['USUARIOS'][$key][7] , $_SESSION['USUARIOS'][$key][8] , $_SESSION['USUARIOS'][$key][9] , $_SESSION['USUARIOS'][$key][10] , $block) ;
	}


}

echo json_encode($jsondata);