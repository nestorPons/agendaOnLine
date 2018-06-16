<?php
$User = new models\User($_POST['idUser']);
$Login->user($User);
if ($User->checkToken($_POST['token'])){
   return $User->password($_POST['pass'])
        ?$Login->createSession()
        :err('Usuario o contraseña incorrectos.',5);
} else return core\Error::array(core\Error::$last);