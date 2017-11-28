<?php 
define('SAVE', 'save') ;
define('DEL', 'del') ;
define('EDIT', 'edit') ;
define('ADD', 'add') ;

require_once URL_CONTROLLERS.'conn.php'; 
require_once URL_CONFIG .'session.php';

if ($conn->error == false ) {

    $confP = $conn->assoc('SELECT * FROM config ') ;
    $configCSS = $conn->assoc('SELECT * FROM config_css ') ;

    $conf = new core\Conexion( 'aol_accesos' ) ;
    $confG =  $conf->assoc( 'SELECT * FROM empresas WHERE id = '.$confP['idEmpresa'] .' LIMIT 1' );
    $browsers =  $conf->all( 'SELECT code , name FROM browsers' );

    foreach($browsers as $browser){
        $browsers_arr['BROWSERS'][$browser [0]] = $browser [1];
    }

   define('CONFIG' , array_merge($confG,$confP,$configCSS,$browsers_arr) );

} else {

    include_once URL_CONTROLLERS . 'error.php';
    exit ;
    
}

//Guardo los anchos de pantalla para posteriores configuraciones
//Si coy a validar existe un Post->ancho 
if( isset($_POST['ancho']) ) $_SESSION['width'] = $_POST['ancho'];
//Si voy a admin o otro lado creo la clase dispositivo 
if (isset($_SESSION['width'])) $Device = new \models\Device($_SESSION['width']);

