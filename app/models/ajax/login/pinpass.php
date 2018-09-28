<?php 
if(isset($_COOKIE["auth"]) && $Login->authToken($_COOKIE["auth"])){
    if ((int)$Login->attempts() <= (int)NUM_MAX_ATTEMPT){
        if($Login->pin() == $_POST['pinpass']){
            $return['action'] =  $Login->createSession();
            return ($Login->admin>0)?['action'=>'admin']:['action'=>'users'] ;
        } else {
            $Login->attempts(1);
            return  $Login->err(\core\Error::E026,5);
        }
    }else{
        //bloqueado por demasiados intentos
		$Login->status(1);
        $Login->statusReset();
        return $Login->err(\core\Error::E024,4) ;
    }
} else {
    $Login->logout();
};
