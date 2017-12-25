<?php 
define('SAVE', 'save') ;
define('DEL', 'del') ;
define('EDIT', 'edit') ;
define('ADD', 'add') ;
define('MARGIN_DAYS',6);
const EMAIL_FROM = 'nestorpons@gmail.com';
const EMAIL_NAME = 'AOL TEAM';
const EMAIL_HOST = 'smtp.gmail.com';
const EMAIL_USER = 'nestorpons@gmail.com';
const EMAIL_PASS = 'PP09ol.__';
const EMAIL_PORT = 25;
const BR = '<br>'; //variable para desarrollo
include (URL_CONFIG . 'admin.php');
$conn = new \core\Conexion(NAME_DB , 2); 
if ($conn->error == false ) {

    $confP = $conn->assoc('SELECT * FROM config ') ;

    if(!empty($confP['idEmpresa'])){
        
        $configCSS = $conn->assoc('SELECT * FROM config_css ') ;
        $conf = new \core\Conexion('aa_db' , 2);    
    
        $confG =  $conf->assoc( 'SELECT * FROM empresas WHERE id = '.$confP['idEmpresa'] .' LIMIT 1' );
        $browsers =  $conf->all( 'SELECT code , name FROM browsers' );

        foreach($browsers as $browser){
            $browsers_arr['BROWSERS'][$browser [0]] = $browser [1];
        }
        $adminConf =  $conf->assoc( 'SELECT * FROM admin WHERE id = '.$confG['idAdmin'] .' LIMIT 1' );
        $arrConf =  array_merge($confG,$confP,$configCSS,$browsers_arr, $adminConf);

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
if (isset($_SESSION['width'])) $Device = new \models\Device($_SESSION['width']);
