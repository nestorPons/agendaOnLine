<?php
core\Security::session() ;
$cls_users = new core\BaseClass('usuarios') ;
$users  = $cls_users->getAll( ) ;
require_once URL_VIEWS . 'usuarios.php' ; 
