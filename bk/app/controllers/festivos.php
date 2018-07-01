<?php 

require_once URL_FUNCTIONS .'tools.php';
$Festivos = new core\BaseClass('festivos');

if (isset($_POST['action'])) {

    $url = URL_AJAX . $_POST['controller'] .'/'. $_POST['action'] . '.php' ;

} else {

    $festivos = $Festivos->getAll() ; 

    $url =  URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 
}

require_once $url;