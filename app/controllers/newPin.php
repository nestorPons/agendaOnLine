<?php

if(isset($_POST['action'])){
    $User = new \models\User($_SESSION['id_usuario']); 
    if($User->set(['pin'=>$_POST['newpinpass']])){
        $action = ($User->isAdmin())?'admin':'users';
    }else{
        die('Error al guardar');    
    }
    
    header('Location: ' . $action);
    exit(0); 
} else {
    $url = URL_VIEWS . 'login/newPin.php' ; 
    require_once $url;
}
