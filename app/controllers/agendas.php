<?php

require_once URL_FUNCTIONS .'tools.php';

$Agendas = new models\Agendas();

$url = (isset($_POST['action'])) ? 
    URL_AJAX . $_POST['controller'] . '.php' :
    URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 

require_once $url;