<?php
if (isset($_POST['action'])) {
    header('Content-Type: application/json');
        $r['success'] = false;
        $action = $_POST['action']; 
        $post = $Forms->sanitize($_POST);

    $User = new models\User($_SESSION['id_usuario']);

        if($User->comparePass($post['oldPass'])){
            
            $r['success'] = $User->pass($post['pass']);

        }
    echo json_encode($r);
} 