<?php 
header('Content-Type: application/json');
$Login = new models\Login;
$Login->logout(false); 
$r['success'] = !empty($Login->session_start());
echo json_encode($r);