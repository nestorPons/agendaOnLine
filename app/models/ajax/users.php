<?php
$r['success'] = true;

switch ($_POST['action']) {
	case 'save' :
		if (isset($_POST['npass'])) {
			if ( $User->validatePass($_POST['npass']) && $User->validateEmail($_POST['email'])){
				$_POST['pass'] = $_POST['npass'];
				unset($_POST['npass']);
				unset($_POST['opass']);	
			} else {
				$r['succcess'] = false ;
			}
		} 
		$r['success'] = $User->set($_POST);
		break;
	case 'del':
		$delCita = new core\BaseClass('del_cita') ;
		$r['succcess'] = $User->saveById();
		break;
}
header('Content-Type: application/json');
echo json_encode($r);
