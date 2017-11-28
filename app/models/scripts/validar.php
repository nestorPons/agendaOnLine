<?php
 if(!empty($_POST["login"]) && !empty($_POST['pass'])){ //step 2

	if($Login->findUserBy('email' , $_POST["login"])){ //step 3
		if ($Login->status()==0 && empty($Login->dateBaja)){

			if ((int)$Login->attempts() <= (int)NUM_MAX_ATTEMPT){

					if($Login->validatePass($_POST["pass"])){
						$Login->attempts(0);
						$return['action'] =  $Login->createSession($_POST["recordar"]??false);
					}else{
						$Login->attempts(1);
						$return = err('Usuario o contraseña incorrectos.',5);
					}	
			}else{
				//bloqueado por demasiados intentos
				$return = err('Cuenta bloqueada. Consulte su administrador.',4) ;
				$Login->status(1); 
				$Login->attempts(0);
			}
		} else {
			$status = $Login->status(); 
			$return = err('Usuario o contraseña incorrectos.',7) ;
		}

	}else{
		$return = err('Usuario o contraseña incorrectos.',6) ;
	}
} else { $return = err('Error en el envio de los datos',2) ;}

return $return ;

function err(string $err, int $num = 0, string $action = 'login'){

	return array(
		'args' => 'err=' . $err , 
		'num' => $num , 
		'action' => $action
	);
}
