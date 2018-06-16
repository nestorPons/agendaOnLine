<?php 
require_once URL_FUNCTIONS .'tools.php';

$User = new models\User($_SESSION['id_usuario']);
$zoneUsers = true ;

if (isset($_POST['action'])) {
    require_once URL_AJAX . $_POST['controller'] . '.php' ;
} else {
    

    $Servicios = new core\BaseClass('servicios') ;
     $_SESSION['SERVICIOS'] = $Servicios->getBy('baja',0 ,'*',MYSQLI_NUM) ;

    $Familias = new core\BaseClass('familias');
    $_SESSION['FAMILIAS'] = $Familias->getBy('mostrar' , 1 , '*' ,  MYSQLI_NUM);

    $records = $User->getHistory();

    require_once    URL_VIEWS_USER . 'users.php' ; 
}