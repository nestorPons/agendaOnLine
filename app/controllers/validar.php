<?php 
$action = 'login' ;

$Login = new \models\Login;
$Forms = new \models\Forms;

$_POST = $Forms->sanitize($_POST);
if ($Forms->validateForm($_POST)){
    
    $script  =  (isset($_POST['pinpass']))?'validarPin.php':'validar.php' ;
    $return = include URL_SCRIPTS . $script;

} else {
    $return = core\Error::array(core\Error::getLast());
}

$args = isset($return['args']) ? '?' . $return['args'] :  '' ; 
$action = $return['action'] . $args ;

//var_dump ($return);
header('Location: ' . $action);

function err(string $err, int $num = 0, string $action = 'login'){

	return array(
		'args' => 'err=' . $err , 
		'num' => $num , 
		'action' => $action
	);
}