<?php
header('Content-Type: application/json');
	$data = $Forms->sanitize($_POST);
		$id = $_SESSION["id_usuario"] ;

		switch ($_POST['action']) {
			case 'save' :
				if (isset($data['npass'])) {
					
					if ( $User->validatePass($data['npass']) && $User->validateEmail($data['email'])){
						$data['pass'] = $data['npass'];
						unset($data['npass']);
						unset($data['opass']);
						
					} else {
						$r = false ;
					}
				} 
				break;
			case 'del':

				$delCita = new core\BaseClass('del_cita') ;
				$id = $data['id'] ;
				$User->saveById();
				break;
		}
echo json_encode($r);
