<?php

if(isset($_POST['action'])){
    $User = new \models\User($_SESSION['id_usuario']); 
    $Login = new models\Login; 

    if($Login->pin($_POST['newpinpass'])){
        $action = ($User->isAdmin())?'admin':'users';
    }else{
        die('Error al guardar');    
    }
    
    include (URL_CONTROLLERS . $action. '.php');

} else {
    $url = URL_VIEWS . 'login/newPin.php' ; 
    require_once $url;
}
