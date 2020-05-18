<?php 
require_once (URL_CLASS.'Horarios.php');

$Horarios = new models\Horarios();

if (isset($_POST['action'])) {
    $r['success']= true; 
    switch($_POST['action']){
        case 'save': 
            foreach($_POST['datos'] as $datos){
                if(!$Horarios->saveById($datos['id'], $datos)) $r['success']= false;      
                $Logs->set( $_SESSION['id_usuario'], $_POST['action'], (int)$datos['id'], $_POST['controller']);             
            } 
            break;
        case 'del':
            foreach($_POST['ids'] as $id){
                $Horarios->deleteById($id);
                $Logs->set( $_SESSION['id_usuario'], $_POST['action'], (int)$id, $_POST['controller']);     
            }
            break;  
        }
        
    header('Content-Type: application/json');
    echo json_encode($r);

} else {

    $Agendas = new models\Agendas();
    $horarios = $Horarios->horarios() ;
    $agendas = $Agendas->get();
    \core\Tools::minifierJS($_POST['controller']); 
    require_once URL_VIEWS_ADMIN . $_POST['controller'] .'.php' ; 

}
