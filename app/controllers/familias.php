<?php
if(isset($_POST['action'])){
    require_once  URL_AJAX . $_POST['controller'] . '/' . $_POST['action'] . '.php' ;
} else { 
    \core\Tools::minifierJS($_POST['controller']);   
    require_once URL_VIEWS_ADMIN . $_POST['controller'] . '.php' ; 
}