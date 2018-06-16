<?php
require_once URL_FUNCTIONS .'tools.php';

if (!empty($_POST['oldPass']) && !empty($_POST['newPass'])){
    header('Content-Type: application/json');

    $User = new \models\User($_SESSION['id_usuario']);
    $pass = password_hash($_POST['newPass'],PASSWORD_BCRYPT);

        $r['success'] =  (password_verify($_POST['oldPass'],$User->get('pass')))
            ? $User->set(['pass'=>$pass])
            : false;
     
    echo json_encode($r) ;
} else {

    $url = (isset($_POST['action'])) ? 
        URL_AJAX . $_POST['controller'] . '.php' :
        URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 

    require_once $url;  
}
