<?php

$Users = new core\BaseClass('usuarios') ;
if (isset($_POST['action'])) {
    header('Content-Type: application/json'); 

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

    echo json_encode($r);
    //require_once URL_AJAX . $_POST['controller'] . '.php' ;

} else {
    
    $users  = $Users->getAll() ;
    require_once URL_VIEWS_ADMIN . 'usuarios.php' ; 

}