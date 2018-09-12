<?php
if (isset($_POST['action'])) {
    $r['success'] = false;
    
    $User = new models\User($_SESSION['id_usuario']);
    
    if($User->comparePass($_POST['oldPass'])){
        
        $r['success'] = $User->pass($_POST['pass']);
        
    }
    header('Content-Type: application/json');
    echo json_encode($r);
} 