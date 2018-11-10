<?php
$User = new models\User($_POST['idUser']);
$Login->user($User);
// Si usuario ha sido desactivado por administracion no se pueda volver a activar
if($User->status()<2){
        if ($User->checkToken($_POST['token'])){
                if($User->password($_POST['pass'])){
                // if el registro es correcto eliminamos el $_POST['action'] 
                // para el script user cargue la vista 
                unset($_POST['action']);
                $return['action'] = $Login->createSession(); 

                }else{
                        $return = 'Error al cambiar la contraseña';
                }
                        
                        
 
                return $return;
        } else return core\Error::array(core\Error::$last);
} else {
        return core\Error::array('E023');
}