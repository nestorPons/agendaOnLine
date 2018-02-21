<?php
if (isset($_POST['action'])){
    header('Content-Type: application/json');
    $action = $_POST['action'];
    $_POST = $Forms->sanitize($_POST);

    require_once URL_AJAX . 'login/' . $action . '.php' ;     
    
    echo json_encode($r);
    
}else if (isset($_POST['view'])){

    require_once URL_VIEWS . 'login/' . $_POST['view'] . '.php';

} else {

    if(!isset($_COOKIE["auth"])||isset($_GET['logout'])){
    
        require_once URL_VIEWS . 'login.php';
        
    } else {

        $Login = new \models\Login;
        if ($action = $Login->authToken($_COOKIE["auth"])){
            require_once URL_VIEWS . '/login/pinpass.php';
        }else{ 
            header('Location: ' . NAME_EMPRESA . '/logout');
        }      
        
    }
}