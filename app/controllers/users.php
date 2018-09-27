<?php 
$User = new models\User($_SESSION['id_usuario']);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'view'){
        if($_POST['section']=='historial') $historial = $User->getData(); 
        
        require_once  URL_VIEWS_USER . $_POST['section'] . '.php' ;

    } else {

        header('Content-Type: application/json');
        require_once URL_AJAX . $_POST['controller'] . '.php' ;
        
        $Logs->set($_SESSION['id_usuario'], SAVE, $_SESSION['id_usuario'], $_POST['controller']); 
        echo json_encode($r);
    }
} else {
        

    $Servicios = new core\BaseClass('servicios') ;
    $_SESSION['SERVICIOS'] = $Servicios->getBy('baja',0 ,'*',MYSQLI_NUM) ;

    $Familias = new core\BaseClass('familias');
    $_SESSION['FAMILIAS'] = $Familias->getBy('mostrar' , 1 , '*' ,  MYSQLI_NUM);

    $historial =  $User->getData(); 

    \core\Tools::minifierJS('users');   
    require_once    URL_VIEWS_USER . 'users.php' ; 
}
