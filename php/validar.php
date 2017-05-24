<?php
require "connect/conexion.php";

$empresa =  $_POST['empresa']??$_SESSION['bd'];
$conexion = conexion($security = false,$bd=$empresa);
$_SESSION['esMobil'] = ($_POST['ancho']<=590)?1:0;

if(isset($_POST["login"])&&isset($_POST['pass'])){
		//LOGIN WEB
	$sql = "SELECT * FROM usuarios WHERE Email LIKE '". $_POST["login"]."';";
	$result = mysqli_query($conexion,$sql);
	if ($r= mysqli_fetch_assoc($result)){
		if($r["Pass"] === $_POST["pass"]){
			if ($r["dateBaja"]==0){
				usuarioRegistrado($r["Id"],$r['Admin'],$r['dateBaja'],$r["Nombre"],$r["Email"], $r["Tel"]);
			}else{err('Cuenta no activada. Consulte su email.');}
		}else{err('La contraseña no coincide.');}
	}else{err('Usuario no registrado.');}
}else if(isset($_COOKIE["PHPSESSID"])&&isset($_COOKIE["marca"])){
	$sql = "SELECT Id,Admin,dateBaja FROM usuarios WHERE cookie = ".$_COOKIE["marca"].";";
	$result = mysqli_query($conexion,$sql);
	if($row = mysqli_fetch_row($result)){
		$activa = !empty($row[2]);
		usuarioRegistrado($row[0],$row[1],$activa,$row[3],$row[4],$row[5]);
	}else{err('noEnc');}
}

function usuarioRegistrado(&$idUsuario,&$permisoAdministrador,&$activa){
	global $bd; 
	global $empresa;
	$_SESSION['id_usuario'] = $idUsuario;
	$_SESSION['bd'] = $empresa;

	if(isset($_POST['recordar'])){crearCookie($idUsuario);}

	if ($permisoAdministrador==1){
		$_SESSION['admin_sesion']=1;
		header ("location:../php/admin/index.php");
	}else{
		$url = $activa?err('Cuenta inactiva'):"../".$empresa."/users/index.php";
		//header ("Location: $url");//REDIRIJO A USUARIOS BLOQUEADOS
	}
}

function crearCookie($id){
	global $conexion;
		if($_POST["recordar"] == true){
			mt_srand(time());
			$rand = mt_rand(1000000,9999999);
			mysqli_query($conexion,"UPDATE usuarios SET cookie=".$rand.$id." WHERE Id=$id") or die(mysqli_error());
			setcookie("id_user", $id, time()+(60*60*24*60),"/");
			setcookie("marca", $rand . $id, time()+(60*60*24*60),"/");
		}
	return true;
}
function err($err){
	echo $err. '->'. $_POST['pass'];
	global $empresa;
	include "connect/destroysession.php";
	//header("location:../empresas/$empresa?closeSession=1&err=".$err);
}
