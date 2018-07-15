<?php 
if ($_POST['view']='dlgHistorial'){
    $User = new models\User($_POST['id']); 
}
require_once URL_TEMPLATES . 'dialogs/' . $_POST['view'] . '.phtml' ;
