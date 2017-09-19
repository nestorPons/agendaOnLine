<?php

$_SESSION['esMobil'] = ($_POST['ancho']<=590)?1:0;
$users = new core\BaseClass('usuarios') ;

if( isset($_POST["login"]) && isset($_POST['pass'])){

	$user = $users->getOneBy('email' , $_POST["login"] );

	if ($user["pass"] === $_POST["pass"]){
		
		$return = ($user["dateBaja"]==0) 
			? usuarioRegistrado($user["id"],$user['admin'],$user['dateBaja'])
			: err('Cuenta bloqueada. Consulte su email.') ;
		
	}else{
		$return = err('Usuario o contraseña incorrectos.');
	}

}else if(isset($_COOKIE["PHPSESSID"])&&isset($_COOKIE["marca"])){

	if( $user = $users->getOneBy( 'cookie', $_COOKIE["marca"])){
		$activa = !empty($user['dateBaja']);
		$return = usuarioRegistrado($user['id'],$user['admin'],$activa);
	}else{
		$return = err('noEnc');
	}

} else {

	$return = 'block' ;

}

return $return ;

//functions
function usuarioRegistrado(&$idUsuario,&$permisoAdministrador,&$activa){
 
	$_SESSION['id_usuario'] = $idUsuario;
	$_SESSION['bd'] = $_REQUEST['empresa'] ; 
	
	if(isset($_POST['recordar'])){crearCookie($idUsuario);}

	if ($permisoAdministrador==1){
		$_SESSION['admin_sesion']=1;
		$return['action'] = 'admin' ; 
	}else{

		$return['action'] = ($activa) ? 'user'	: 'user_block' ;

	}

	return $return ;
}

function crearCookie($id){
	global $users;
	if($_POST["recordar"] == true){
		mt_srand(time());
		$rand = mt_rand(1000000,9999999);
		$users->saveById($id , array('cookie'=>$ran.$id));

		setcookie("id_user", $id, time()+(60*60*24*60),"/");
		setcookie("marca", $rand . $id, time()+(60*60*24*60),"/");
	}
	return true;
}

function err($err){
	
	return array(
		'args' => 'err=' . $err , 
		'action' => 'login'
	);
}
