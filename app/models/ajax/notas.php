<?php 
$post = $Forms->sanitize($_POST);
header('Content-Type: application/json');
switch ($_POST['action']){
    case SAVE:
        $r['success'] = $Notas->SaveBy(['fecha'=>$_POST['fecha']], $post) ;
        break;
    case DEL :
        $r['success'] = $Notas->DeleteBy('fecha',$_POST['fecha']);
        break;
    case GET :
        $r['data'] = trim($Notas->getOneBy('fecha',$_POST['fecha'], 'nota'));
        $r['success'] = !empty($r['data']);
        break;
}
echo json_encode($r) ;