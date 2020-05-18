<?php

if (!empty($_POST['oldPass']) && !empty($_POST['newPass'])){
    header('Content-Type: application/json');

    $User = new \models\User($_SESSION['id_usuario']);
    $pass = password_hash($_POST['newPass'],PASSWORD_BCRYPT);

        $r['success'] =  (password_verify($_POST['oldPass'],$User->get('pass')))
            ? $User->set(['pass'=>$pass])
            : false;
     
    echo json_encode($r) ;
} else {
    if(isset($_POST['action'])){
        require_once (URL_AJAX . $_POST['controller'] . '.php');

    } else { 
        \core\Tools::minifierJS($_POST['controller']); 
        require_once (URL_VIEWS_ADMIN . $_POST['controller'] .'.php'); 

    }
}
