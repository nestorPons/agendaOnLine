<?php 
const VERSION = 'v8.3.9'; 
const STABLE = false; 

const PREFIX_DB = 'rtc_'; 
const MARGIN_DAYS = 7; 
const DEFAULT_HISTORY_DAYS = 1;
const NUM_MAX_ATTEMPT = 10; //attempts for crack brute force pass


define('NAME_EMPRESA' ,  $Empresa->name());
define('NAME_CODE' ,  $Empresa->code());
// Se necesita para no tener que declarar en la clase BaseClass y poder poner una bd por defecto
define('NAME_DB' , $Empresa->dbName() );

define('URL_EMPRESA' , URL_EMPRESAS . $Empresa->code() . '/' );
define('URL_LOGO' , file_exists(URL_EMPRESA."logo_128.png")?'empresas/'.$Empresa->code()."/logo_128.png":"img/logo_128.png");
define('URL_LOGO_48' , file_exists(URL_EMPRESA."logo_48.png")?'empresas/'.$Empresa->code()."/logo_48.png":"img/logo_48.png");
define('URL_BACKGROUND' , '/empresas/'.$Empresa->code()."/background.jpg");

//Define los festivos y usa la variable $conn para hacer la conexion 
define('FESTIVOS' , $Empresa->festivos() );

$Agendas = new models\Agendas();
$myAgenda['totalAgendas'] = $Agendas->count();

define('CONFIG', array_merge($Empresa->getConf(),$myAgenda));

//Guardo los anchos de pantalla para posteriores configuraciones
//crear cookie configAOl para ancho de pantalla y otras configuraciones
//Si coy a validar existe un Post->ancho 

//Si voy a admin o otro lado creo la clase dispositivo 
$Device = new \models\Mobile_Detect;
define('CLASS_BACKGROUND', classBackGround());

function classBackground(){
    global $Device;
    return $Device->isMobile()
        ?""
        :file_exists(URL_EMPRESA ."background.jpg")
                ?"background-personalized"
                :"background";
}