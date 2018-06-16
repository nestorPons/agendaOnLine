<?php

$Users = new core\BaseClass('usuarios') ;
if (isset($_POST['action'])) {

    core\Tools::encodeJSON(URL_AJAX . $_POST['controller'] . '.php');
    
} else {
    
    $users  = $Users->getAll('*',MYSQLI_ASSOC) ;
    require_once URL_VIEWS_ADMIN . 'usuarios.php' ; 

}