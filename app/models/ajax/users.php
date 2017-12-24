<?php
header('Content-Type: application/json');
$Forms = new models\Forms;
$data = $Forms->sanitize($_POST);
if ($Forms->validateForm($data,['tel'])){
	$id = $_SESSION["id_usuario"] ;

	switch ($_POST['action']) {
		case 'save' :
			if (isset($data['npass'])) {
				
				if ( $User->validatePass($data['npass']) && $User->validateEmail($data['email'])){
					$data['pass'] =  $data['npass'];
					unset($data['npass']);
					unset($data['opass']);
					
				} else {
					$r = false ;
				}

			} 
			$r = $User->saveById($id , $data) ;

			break;
		case 'del':

			$delCita = new core\BaseClass('del_cita') ;
			$id = $data['id'] ;
			$User->saveById();
			break;
	}

	echo json_encode($r);
}