<?php 

require_once $_SESSION['FILE_CONFIG'] ;
require_once URL_FUNCTIONS . 'tools.php';

require_once URL_TEMPLATES . $_POST['controller'] . '/' . $_POST['view'] . '.phtml' ;
