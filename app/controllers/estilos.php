<?php

$url = (isset($_POST['action'])) ? 
    URL_AJAX . $_POST['controller'] . '/' . $_POST['action'] . '.php' :
    URL_VIEWS_ADMIN . 'estilos.php' ; 

require_once $url ; 