<?php 
    global $Users;
    
    $data = $_POST ;
    $action = $data['action'];

    unset($data['controller']) ;
    unset($data['action']) ;

    switch ($action){
        case SAVE:
            $r['success'] = $Users->saveById( $data['id'] , $data ) ; 
            $r['id'] = $Users->getId(); 
            break;
        case DEL:
            $r['success'] = $Users->saveById( $data['id'], ['dateBaja'=>date('Y-m-d H:i:s')]) ; 
            break;
    }