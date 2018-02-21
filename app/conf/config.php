<?php 
//Se declara NAME_DB en confing para que no se declare antes de crear una empresa
define('NAME_EMPRESA' , strtolower(trim($_REQUEST['empresa']??FALSE)) );
define('NAME_DB' , 'bd_' . NAME_EMPRESA??FALSE );
define('URL_EMPRESA' , URL_EMPRESAS . NAME_EMPRESA . '/' );
define('URL_LOGIN','/'.NAME_EMPRESA);
define('URL_LOGO' , file_exists(URL_EMPRESA."logo.png")?'/empresas/'.NAME_EMPRESA."/logo.png":"img/logo.png");
define('URL_BACKGROUND' , '/empresas/'.NAME_EMPRESA."/background.jpg");

$conn = new \core\Conexion('bd_' . NAME_EMPRESA , 2); 
//Define los festivos y usa la variable $conn para hacer la conexion 
define('FESTIVOS' , include_once (URL_SCRIPTS . 'festivos.php') );

define('AOL_WEB','http://www.aol.com');
define('AOL_EMAIL', 'nestorpons@gmail.com');

include (URL_CONFIG . 'admin.php');

if ($conn->error == false ) {

    $confP = $conn->assoc('SELECT * FROM config ') ;
 
    if(!empty($confP['idEmpresa'])){
        
        $configCSS = $conn->assoc('SELECT * FROM config_css ') ;
        $conf = new \core\Conexion('aa_db' , 2);    
    
        $confG =  $conf->assoc( 'SELECT * FROM empresas WHERE id = '.$confP['idEmpresa'] .' LIMIT 1' );
        $browsers =  $conf->all( 'SELECT code , name FROM browsers' );

        foreach($browsers as $browser){
            $browsers_arr['BROWSERS'][$browser[0]] = $browser[1];
        }
    
        $arrConf =  array_merge($confG,$confP,$configCSS,$browsers_arr);

    } else {
        
        die ('Error 001  : No se puede cargar la configuración');
        $arrConf = FALSE;
    }

    define('CONFIG', $arrConf );
} else {

    include_once URL_VIEWS . 'error.php';
    exit ;
    
}

//Guardo los anchos de pantalla para posteriores configuraciones
//Si coy a validar existe un Post->ancho 
if( isset($_POST['ancho']) ) $_SESSION['width'] = $_POST['ancho'];
//Si voy a admin o otro lado creo la clase dispositivo 
$Device = new \models\Device($_SESSION['width']??false);

define('CLASS_BACKGROUND', classBackGround());
function classBackground(){
    global $Device;
    return $Device->isMovile
        ?""
        :file_exists(URL_EMPRESA ."background.jpg")
                ?"background-personalized"
                :"background";
}