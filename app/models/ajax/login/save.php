<?php 

$Users = new \core\BaseClass('usuarios') ;
if ($Users->getOneBy('email',$_POST['email'],'id','num') != false) {
        $r = core\Error::array('E022'); 
} else {
    foreach($_POST as $val){
        if (empty($val)){
            $r = core\Error::array('E005');
            return false;
        } 
    }
    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $Users->saveById(-1, $_POST);
    $User = new models\User($Users->getId());
    $Mail = new models\Mail($User);

    $Mail->url_menssage = URL_SOURCES . 'mailactivate.php';


    $Mail->AltBody = 'Activar cuenta:';
    $r['success'] = $Mail->send(); 
    if (!empty(core\Error::$Last)) return core\Error::array(core\Error::getLast()); 
    return $r;

}
