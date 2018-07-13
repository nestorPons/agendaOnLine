<?php 
require_once (URL_CLASS.'Horarios.php');

$Horarios = new models\Horarios();

if (isset($_POST['action'])) {
    $accion = $_POST['action'] ;
    header('Content-Type: application/json');
    $post = $Forms->sanitize($_POST);
    $r['success']= true; 
    switch($accion){
        case 'save': 
            foreach($_POST['datos'] as $datos){
                if(!$Horarios->saveById($datos['id'], $datos)) $r['success']= false;              
            }        
        break;
        case 'del':
        foreach($_POST['ids'] as $id){
            $Horarios->deleteById($id);
        }
        break;  
    }

    echo json_encode($r);

} else {

    $Agendas = new models\Agendas();
    $horarios = $Horarios->horarios() ;
    $agendas = $Agendas->get();
    require_once URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 

}
