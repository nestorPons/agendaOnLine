<?php
  
if(!isset($_COOKIE["id_user"])){

    core\Security::destroy_session() ;
    require_once(URL_SCRIPTS . 'login.php') ;
    require_once(URL_VIEWS . 'login.php') ;

} else {

    //header ("location:http://".URL_SCRIPTS."/validar.php");

}
