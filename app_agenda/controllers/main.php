<?php 
require_once URL_CLASS      . 'Lbl.php';
require_once URL_FUNCTIONS  . 'main.view.php';

if (isset ($_POST['action'])){
    functions\view($_POST['fecha']??date('Y-m-d'));

} else {

    require_once URL_VIEWS_ADMIN . 'main.php';
    
}