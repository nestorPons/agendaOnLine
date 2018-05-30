<?php 


//Se declara NAME_DB en confing para que no se declare antes de crear una empresa
define('CODE_EMPRESA' , strtolower(trim($_REQUEST['empresa']??FALSE)) );

$Empresa = new models\Empresa(CODE_EMPRESA);

define('NAME_EMPRESA' ,  $Empresa->name());
define('NAME_DB' , PREFIX_DB . CODE_EMPRESA??FALSE );
define('URL_EMPRESA' , URL_EMPRESAS . CODE_EMPRESA . '/' );
define('URL_LOGIN','/'.CODE_EMPRESA);
define('URL_LOGO' , file_exists(URL_EMPRESA."logo.png")?'/empresas/'.CODE_EMPRESA."/logo.png":"img/logo.png");
define('URL_BACKGROUND' , '/empresas/'.CODE_EMPRESA."/background.jpg");

//Define los festivos y usa la variable $conn para hacer la conexion 
define('FESTIVOS' , $Empresa->festivos() );

$Agendas = new models\Agendas();
$myAgenda['totalAgendas'] = $Agendas->count();
define('CONFIG', array_merge($Empresa->getConf(),$myAgenda));

//Guardo los anchos de pantalla para posteriores configuraciones
//crear cookie configAOl para ancho de pantalla y otras configuraciones
//Si coy a validar existe un Post->ancho 
if(!isset($_COOKIE['width']) && isset($_POST['ancho']))
   setcookie('width',  $_POST['ancho'], time() + strtotime( '+360 days' ));  

//Si voy a admin o otro lado creo la clase dispositivo 
$Device = new \models\Device($_COOKIE['width']??false);

define('CLASS_BACKGROUND', classBackGround());

function classBackground(){
    global $Device;
    return $Device->isMovile
        ?""
        :file_exists(URL_EMPRESA ."background.jpg")
                ?"background-personalized"
                :"background";
}