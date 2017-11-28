<?php 
require_once URL_FUNCTIONS .'tools.php';

$User = new models\User($_SESSION['id_usuario']);
$zoneUsers = true ;

if (isset($_POST['action'])) {

    require_once URL_AJAX . $_POST['controller'] . '.php' ;
} else {
    define('FESTIVOS' , include_once (URL_SCRIPTS . 'festivos.php') );

    $Servicios = new core\BaseClass('servicios') ;
    $servicios = $Servicios->getBy('baja' ,  0 , '*' ,  MYSQLI_NUM) ;
    $_SESSION['SERVICIOS']= $servicios;

    $Familias = new core\BaseClass('familias');
    $familias = $Familias->getBy('mostrar' , 1 , '*' ,  MYSQLI_NUM);
    $_SESSION['FAMILIAS']  = $familias ;

    $Agendas = new core\BaseClass('agendas');
    $agendas = $Agendas->getBy('mostrar', 1);
    
    $records = $User->getHistory();

    require_once    URL_VIEWS_USER . 'users.php' ; 
}