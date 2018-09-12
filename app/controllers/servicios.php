<?php
include (isset($_POST['action'])) 
    ? URL_AJAX . $_POST['controller'] . '.php' 
    : URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 