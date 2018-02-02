<?php 
$action = 'login' ;

$Login = new \models\Login;
//var_dump($_POST);

$_POST = $Forms->sanitize($_POST);

	$script  =  (isset($_POST['token']))
		?'newpass.php'
		:(isset($_POST['pinpass'])
			?'pinpass.php'
			:'loginpass.php' );
		
	$return = include URL_SCRIPTS . 'validates/' . $script;

if (isset($return['action'])){
	$args = isset($return['args']) ? '?' . $return['args'] :  '' ; 
	$action = $return['action']. $args ;
} else $action = 'login';

if (!empty($_SESSION['id_usuario'])) {
	// Se guarda en el historial de movimientos 
	//$idUser, $action,$idFK,$status,$tables
	$Logs->set($_SESSION['id_usuario'], 'login' , 0 , $return['action']); 
}

//var_dump ($return);
header('Location: ' . $action);

function err(string $err, int $num = 0, string $action = 'login'){

	return array(
		'args' => 'err=' . $err , 
		'num' => $num , 
		'action' => $action
	);
}