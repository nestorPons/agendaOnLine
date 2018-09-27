<?php  
$Login = new \models\Login;
// Si hay un post token vengo de validar email de registro
// si existe post pinpass hay que validar entrada por pin
// si no que valide el formulario normal de entrada
// Post token no es igual que session token 

$script  =  
	(isset($_POST['token']))
		// Viene de recordar contraseña
		?'newpass.php'
		:(isset($_POST['pinpass'])
			// Viene de loguearse con pin
			?'pinpass.php'
			// Viene de login principal
			:'loginpass.php' ); 

$return = include URL_AJAX . 'login/' . $script;

if( !isset($return['action']) || $return['action'] == 'login'){

	// En newpass no se crea el action hay que  enviarlo al login
	// si el logeo es erroneo se devuelve jsjon con el error
	header('Content-Type: application/json');
	echo json_encode($return);
}else{
	// Si es correcto se devuelve la vista

	include (URL_CONTROLLERS . $return['action'] . '.php');
}
