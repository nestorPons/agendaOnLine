<?php 
if ($User = new models\User(false, $_POST['email'])){
    $Mail = new models\PHPMailer(true);
        
    include_once URL_CONFIG . 'mail.php';

    $Mail->addAddress($User->email, $User->nombre);   
    $Mail->url_menssage = URL_SOURCES . 'mailRecovery.php';
    $Mail->Body    = \core\Tools::get_content($Mail->url_menssage, $User->getToken());
    $Mail->AltBody = 'Reestablecer contraseña: ' .  $User->token;
    $Mail->Subject =  "Reestablece contraseña";

    $r['success'] = $Mail->send($User);
} else {
    return core\Error::array(core\Error::getLast());
}
