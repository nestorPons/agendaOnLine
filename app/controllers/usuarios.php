<?php
if (isset($_POST['action'])) {
    header('Content-Type: application/json');
    $data = $_POST ;
    $action = $data['action'];

    $data = $Forms->sanitize($_POST);

    $User = new models\User($data['id']) ;

    switch ($action){
        case SAVE:  
            if(empty($data['email'])) unset($data['email']); 
            $r['success'] = $User->save($data) ; 
            $r['id'] = $User->getId(); 
            break;
        case DEL:
            $r['success'] = $User->save( ['dateBaja'=>date('Y-m-d H:i:s')]) ; 
            break;
        case 'historial':
            $ini = new \DateTime('2000-07-01');
            $end = new \DateTime(); 
            $r['data'] = $User->history($ini, $end, $_POST['limit']); 
            $r['success'] =  $r['data']!=null; 
            break;
    }
    echo json_encode($r);
} else {
    
    $Users = new core\BaseClass('usuarios') ;
    $users  = $Users->getAll('*',MYSQLI_ASSOC,'nombre') ;
    require_once URL_VIEWS_ADMIN . 'usuarios.php' ; 

}