<?php
header('Content-Type: application/json');

$js['success'] =false;
$idUsuario = trim($_POST['idUsuario'])??null;
$nombre = Trim($_POST["nombre"])??null ;
$email  = Trim($_POST["email"])??"";
$pass1 = trim($_POST["pass1"])??"";
$pass2 = trim($_POST["pass2"])??"";
$Tel  = $_POST['tel']??"";
$oldPass = trim($_POST["oldPass"])??"";

function validarPass(){
	$sql = "SELECT Id FROM usuarios WHERE Id  =  $idUsuario AND Pass ='$oldPass'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)!=0){
		global $pass1;
		global $pass2;
		return $pass1==$pass2;		
	}else{
		return false;
	}
}

function validarEmail(){
	global $email;
	global $conexion;
	$sql = "SELECT Email FROM usuarios WHERE Id  = " . $idUsuario;
	$emailBD = mysqli_fetch_row(mysqli_query($conexion,$sql));
	if($emailBD[0]!=$email){
		$sql = "SELECT Id FROM usuarios WHERE Email  = " . $email;
		if(mysqli_num_rows(mysqli_query($conexion,$sql))!=0){ 
			$js['success'] = false;
			$js['mensError'] = ""
			return false;
		}		
	}
	return true;
}

if (validarEmail&&validarPass){
	$pass =!empty($pass1)?", Pass='".$pass1. "' ,datePass = '" . date('Y-m-d') ."'":"";	
	$SQL = "UPDATE usuarios SET Nombre ='$nombre',Email='$email',Tel ='$Tel' ".$pass." WHERE Id =$idUsuario";
	$js['sql']=$SQL;
	 if (mysqli_query($conexion,$SQL) ){
		registrarEvento(5,0,$_SESSION["id_usuario"],0);
		$js['success'] = true;
	 }	
}
echo json_encode($js);