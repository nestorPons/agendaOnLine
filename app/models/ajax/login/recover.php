<?php 

    $User = new \models\User(false, $_POST['email']); 
    if ($User->id){
        $Mail = new \models\PHPMailer(true);

        $Mail->addAddress($User->email, $User->nombre);   
        $Mail->url_menssage = URL_SOURCES . 'mailRecovery.php';
        $Mail->Body    = \core\Tools::get_content($Mail->url_menssage, $User->getToken());
        $Mail->AltBody = 'Reestablecer contraseña: ' .  $User->token;
        $Mail->Subject =  "Reestablece contraseña";

        $r['success'] = $Mail->send($User);
    } else {
       $r = core\Error::array('E025');
    }
