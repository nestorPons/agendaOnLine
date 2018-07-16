<?php 
    global $Users, $Forms;
    
    $data = $_POST ;
    $action = $data['action'];

   $data = $Forms->sanitize($_POST);

    switch ($action){
        case SAVE:  
            if(empty($data['email'])) unset($data['email']); 
            $r['success'] = $Users->saveById( $data['id'] , $data ) ; 
            $r['id'] = $Users->getId(); 
            break;
        case DEL:
            $r['success'] = $Users->saveById( $data['id'], ['dateBaja'=>date('Y-m-d H:i:s')]) ; 
            break;
        case 'historial':
            $ini = new \DateTime('2000-07-01');
            $end = new \DateTime();
            $User = new models\User($_POST['id']); 
            $r['data'] = $User->history($ini, $end, $_POST['limit']); 
            $r['success'] =  $r['data']!=null; 
            break;
    }