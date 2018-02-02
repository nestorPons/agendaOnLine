<?php 

$Users = new \core\BaseClass('usuarios') ;
if ($Users->getOneBy('email',$_POST['email'],'id','num') != false) {
        $r = core\Error::array('E022'); 
} else {
    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $Users->saveById(0, $_POST);
    $User = new models\User($Users->getId());
    $Mail = new models\Mail;
    $Mail->url_menssage = URL_SOURCES . 'mailactivate.php';
    $Mail->AltBody = 'Activar cuenta: ' .  $User->token;
    $r['success'] = $Mail->send($User); 
    if (!empty(core\Error::$Last)) return core\Error::array(core\Error::getLast()); 
    return $r;
}
