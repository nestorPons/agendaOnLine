<?php 
if ($User = new models\User(false, $_POST['email'])){
    $Mail = new models\Mail;
    $Mail->url_menssage = URL_SOURCES . 'mailRecovery.php';
    $Mail->AltBody = 'Reestablecer contraseña: ' .  $User->token;
    $r['success'] = $Mail->send($User);
} else {
    return core\Error::array(core\Error::getLast());
}
