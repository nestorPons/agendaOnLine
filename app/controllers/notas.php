<?php

$Notas = new core\BaseClass('notas');
if(isset($_POST['action'])){

    switch ($_POST['action']){
        case SAVE:
        if($r['success'] = $Notas->SaveById((int)$_POST['id'], $_POST))
        $id = $r['id'] = $Notas->getId();        
        break;
        case DEL :
        if($r['success'] = $Notas->DeleteById((int)$_POST['id']))
        $id = $_POST['id']; 
        break;
        case GET :
        $r['data'] = $Notas->getBy('fecha',$_POST['fecha']);
        $r['success'] = !empty($r['data']);
        break;
    }
    if(isset($id)) $Logs->set($_SESSION['id_usuario'],$_POST['action'], $id, $_POST['controller'] ); 
   
    header('Content-Type: application/json');
    echo json_encode($r) ;
}
else
{
    require_once    URL_VIEWS_ADMIN . 'notas.php' ; 
}   

 