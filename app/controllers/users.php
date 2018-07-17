<?php 
require_once URL_FUNCTIONS .'tools.php';

$User = new models\User($_SESSION['id_usuario']);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'view'){
        if($_POST['section']=='historial') $historial = $User->getData(); 
        
        require_once  URL_VIEWS_USER . $_POST['section'] . '.php' ;

    } else {
        
        require_once URL_AJAX . $_POST['controller'] . '.php' ;
    }
} else {
        

    $Servicios = new core\BaseClass('servicios') ;
     $_SESSION['SERVICIOS'] = $Servicios->getBy('baja',0 ,'*',MYSQLI_NUM) ;

    $Familias = new core\BaseClass('familias');
    $_SESSION['FAMILIAS'] = $Familias->getBy('mostrar' , 1 , '*' ,  MYSQLI_NUM);

    $historial = $User->getData(); 


    require_once    URL_VIEWS_USER . 'users.php' ; 
}
