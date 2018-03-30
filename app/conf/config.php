<?php 
const MARGIN_DAYS = 6;
const DEFAULT_HISTORY_DAYS = 1;
const NUM_MAX_ATTEMPT = 7; //attempts for crack brute force pass

define ('ADMIN_WEB','http://57230b1799704ccc80ad7f3bbfad7c95.yatu.ws');
define ('ADMIN_NAME' , 'Nestor Pons') ; 
define ('ADMIN_EMAIL' , 'nestorpons@gmail.com') ; 

//Se declara NAME_DB en confing para que no se declare antes de crear una empresa
define('CODE_EMPRESA' , strtolower(trim($_REQUEST['empresa']??FALSE)) );
$Empresa = new models\Empresa(CODE_EMPRESA);

define('NAME_EMPRESA' ,  $Empresa->name());
define('NAME_DB' , 'bd_' . CODE_EMPRESA??FALSE );
define('URL_EMPRESA' , URL_EMPRESAS . CODE_EMPRESA . '/' );
define('URL_LOGIN','/'.CODE_EMPRESA);
define('URL_LOGO' , file_exists(URL_EMPRESA."logo.png")?'/empresas/'.CODE_EMPRESA."/logo.png":"img/logo.png");
define('URL_BACKGROUND' , '/empresas/'.CODE_EMPRESA."/background.jpg");

//Define los festivos y usa la variable $conn para hacer la conexion 
define('FESTIVOS' , include_once (URL_SCRIPTS . 'festivos.php') );

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