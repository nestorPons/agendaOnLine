<?php

if(isset($_POST['action'])){
    $User = new \models\User($_SESSION['id_usuario']); 
    $Login = new models\Login; 

    if($Login->pin($_POST['newpinpass'])){
        $action = ($User->isAdmin())?'admin':'users';
    }else{
        die('Error al guardar');    
    }
    // SE elimina la accion para que muestre la vista desde el controlador
    unset($_POST['action']);
    include (URL_CONTROLLERS . $action. '.php');

} else {
    $url = URL_VIEWS . 'login/newPin.php' ; 
    require_once $url;
}
