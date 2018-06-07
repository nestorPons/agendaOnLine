<?php 
$post = $Forms->sanitize($_POST);
header('Content-Type: application/json');
switch ($_POST['action']){
    case SAVE:
        $r['success'] = $Notas->SaveById((int)$_POST['id'], $post) ;
        $r['id'] = $Notas->getId(); 
        break;
    case DEL :
        $r['success'] = $Notas->DeleteById((int)$_POST['id']);
        break;
    case GET :
        $r['data'] = trim($Notas->getOneBy('fecha',$_POST['fecha'], 'nota'));
        $r['success'] = !empty($r['data']);
        break;
}
echo json_encode($r) ;