<?php

require_once URL_FUNCTIONS .'tools.php';

$url = (isset($_POST['action'])) ? 
    URL_AJAX . $_POST['controller'] . '.php' :
    URL_VIEWS . $_POST['controller'] .'.php' ; 

require_once $url;