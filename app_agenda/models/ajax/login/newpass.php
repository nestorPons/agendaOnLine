<?php
$User = new models\User($_POST['idUser']);
$Login->user($User);
// Si usuario ha sido desactivado por administracion no se pueda volver a activar
if($User->status()<2){
        if ($User->checkToken($_POST['token'])){
                if($User->password($_POST['pass'])){
                        unset($_POST['action']);        
                        $return['action'] = $Login->createSession(); 
                }else{
                        $return = 'Error no se ha podido guardar el password';
                }
                return $return;
        } else return core\Error::array(core\Error::$last);
} else {
        return core\Error::array('E023');
}