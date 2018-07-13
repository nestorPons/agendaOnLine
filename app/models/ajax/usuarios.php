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
    }