<?php
header('Content-Type: application/json');

$data = $_POST ;
$id = $_SESSION["id_usuario"] ;
$action = $_POST['action'];
unset($data['controller']);
unset($data['action']);

switch ($action) {
	case 'add' :
		if (isset($data['npass'])) {
			
			if ( $User->validatePass($data['npass']) && $User->validateEmail($data['email'])){
				$data['pass'] =  $data['npass'];
				unset($data['npass']);
				unset($data['opass']);

				$r = $User->saveById($id , $data) ;
			} else {
				$r = false ;
			}

		} else {
			$r = $User->saveById($id , $data) ;
		}

		break;
	case 'del':

		$delCita = new core\BaseClass('del_cita') ;
		$id = $_POST['id'] ;
		$User->SaveById();
		break;
}

echo json_encode($r);