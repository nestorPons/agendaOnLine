<?php header('Content-Type: application/json');
    try{
        $Servicios = new core\BaseClass('servicios');

        $id = $_POST['id']??-1;

        $r = [
            'codigo' => $_POST['codigo']??exit, 
            'descripcion' => trim($_POST['descripcion']) , 
            'tiempo' => $_POST['tiempo']??10 , 
            'precio' => $_POST['precio']??0 , 
            'idFamilia' => $_POST['idFamilia']??1 ,
            'baja' => $_POST['baja']??0
        ];

        $r['success']  = $Servicios->saveById($id , $r);
        $r['id'] =  ($id == -1 ) ? $Servicios->getId() : $id ;
        $_SESSION['SERVICIOS'] = $Servicios->getAll() ;
        
        $Logs->set( $_SESSION['id_usuario'], $_POST['action'], $r['id'], $_POST['controller']);

    } catch(Exception $e){
        $r = false; 
    }
    echo json_encode($r) ;