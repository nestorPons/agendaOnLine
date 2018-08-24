<?php
if(!empty($_POST["login"]) && !empty($_POST['pass'])){ 	
	if($Login->findUserBy('email' , $_POST["login"])){ 
		
		if ($Login->status()==0 && empty($Login->dateBaja)){
			if ((int)$Login->attempts() <= (int)NUM_MAX_ATTEMPT){
				if($Login->validatePass($_POST["pass"])){
					/**
					 * Todo correcto se crea y registra una sesion 
					 */
					$return['action'] =  $Login->createSession((bool)$_POST["recordar"]);
					/**
					 * Comprobamos si se ha seleccionado login con pin 
					 */
					if(($_POST['recordar'] && empty($Login->pin))){
						// Si se ha seleccionado y el pin esta vacio enviamos a la pantalla newPin para registrar un nuevo pin 
						$return['action'] = 'newPin'; 
					}
				}else{
					$Login->attempts(1);
					$return = $Login->err(\core\Error::E026,5);
				}	

			}else{
				//bloqueado por demasiados intentos					
				$Login->status(1);
				$Login->statusReset();
				$return = $Login->err(\core\Error::E024,4);
			}
		} else	{
			// Diferenciamos si ha sido bloqueado 
			// por varios intentos o desactivado por administración
			$return = ($Login->status()==1)
				?$Login->err(\core\Error::E028,7)
				:$Login->err(\core\Error::E023,7) ;
		}

	}else $return = $Login->err(\core\Error::E026,6);
	
} else $return = $Login->err(\core\Error::E006,2);

return $return ;