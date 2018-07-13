<?php

$Notas = new core\BaseClass('notas');
$url = (isset($_POST['action'])) ? 
    URL_AJAX . $_POST['controller'] . '.php' :
    URL_VIEWS_ADMIN . 'notas.php' ; 

require_once $url;