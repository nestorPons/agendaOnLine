<?php 

require_once URL_ROOT . 'app/conf/config.php';
require_once URL_FUNCTIONS . 'tools.php';

require_once URL_TEMPLATES . $_POST['controller'] . '/' . $_POST['view'] . '.phtml' ;
