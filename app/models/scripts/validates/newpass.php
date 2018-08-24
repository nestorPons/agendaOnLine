<?php

$User = new models\User($_POST['idUser']);
$Login->user($User);
// Si usuario ha sido desactivado por administracion no se pueda volver a activar
if($User->status()<2){
        if ($User->checkToken($_POST['token'])){
                $return['action'] = $User->password($_POST['pass'])
                        ?$Login->createSession()
                        :false;
                return $return;
        } else return core\Error::array(core\Error::$last);
} else {
        return core\Error::array('E023');
}