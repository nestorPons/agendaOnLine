<?php 
header('Content-Type: application/json');
$Login = new models\Login;
$Login->logout(false,false); 
$r['success'] = !empty($Login->session_start());
echo json_encode($r);