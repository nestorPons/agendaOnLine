<?php
$cls = new models\Servicios();
switch ($_POST['action']){
    case 'del' :
        $r = $cls->deleteById($_POST['id']) ;
        break;
    case 'save' :

        break;

}
