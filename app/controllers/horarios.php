<?php 
require_once (URL_CLASS.'Horarios.php');

$Horarios = new models\Horarios();

if (isset($_POST['action'])) {

    $url =  URL_AJAX . $_POST['controller'] . '.php' ;

} else {

    $Agendas = new models\Agendas();
    $horarios = $Horarios->all() ;
    
    $url = URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 

}

require_once $url;