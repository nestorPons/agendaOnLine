<?php 
$Users = new \core\BaseClass('usuarios') ;

if ($Users->getOneBy('email',$_POST['email'],'id','num') != false) {
        $r = core\Error::array('E022'); 
} else {
    foreach($_POST as $val){
        if (empty($val)){
            $r = core\Error::array('E005');
            return $r;
        } 
    }
    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $Users->saveById(-1, $_POST);
    $User = new \models\User($Users->getId());

// -- envio de email
    
    $Mail = new \models\PHPMailer(true);

    $Mail->Subject = "Activar nueva cuenta";
    $Mail->addAddress($User->email, $User->nombre);   
    $Mail->url_menssage = URL_EMAILS . 'mailactivate.php';
    $Mail->Body    = \core\Tools::get_content($Mail->url_menssage, $User->getToken());
    $Mail->AltBody = 'Activar usuario: ' .  $User->token;
    $Mail->Subject =  "Activar cuenta";

    if(!$Mail->send()){
        $r = core\Error::array('E071');
    } else{ 
        $r['success'] = true;
    }
//--
    if (!empty(core\Error::$Last)) return core\Error::array(core\Error::getLast()); 
    return $r;
}