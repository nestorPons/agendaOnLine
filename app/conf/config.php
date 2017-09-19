<?php 

$arr = explode('/', $_SERVER['DOCUMENT_ROOT'] ) ;
define('URL_ROOT' , str_replace(array_pop($arr),'',$_SERVER['DOCUMENT_ROOT']) );

$_SESSION['FILE_CONFIG'] = URL_ROOT . 'app/conf/config.php' ;

define('NAME_DB' , $_REQUEST['empresa'] );

define('URL_AJAX' , URL_ROOT . 'app/models/ajax/' );
define('URL_CLASS' , URL_ROOT . 'app/models/class/' );
define('URL_CONTROLLERS' , URL_ROOT . 'app/controllers/' );
define('URL_CONFIG' , URL_ROOT . 'app/conf/' );
define('URL_CORE' , URL_ROOT . 'app/core/' );
define('URL_CSS' , URL_ROOT . 'web/css/' );
define('URL_EMPRESAS' , URL_ROOT . 'web/empresas/' );
define('URL_EMPRESA' , URL_ROOT . '/web/empresas/' .  NAME_DB . '/' );
define('URL_JS' , URL_ROOT . 'web/js/' );
define('URL_FUNCTIONS' ,  URL_ROOT . 'app/models/functions/' ); 
define('URL_SCRIPTS' , URL_ROOT . 'app/models/scripts/' );
define('URL_SOURCES' , URL_ROOT . 'app/sources/' );
define('URL_TEMPLATES' , URL_ROOT . 'app/views/templates/' );
define('URL_VIEWS' , URL_ROOT . 'app/views/' );

define('SAVE', 'save') ;
define('DEL', 'del') ;
define('EDIT', 'edit') ;
define('ADD', 'add') ;
// Classes autoload OG
spl_autoload_register(function ($classname) {


    $arr_explode = explode("\\" , $classname) ; 
    $namespace = $arr_explode[0];
    $className = $arr_explode[1];

    if ( $namespace == 'models' ){
        $filename = URL_CLASS . $className . '.php' ;
    } else {
        $classname = str_replace ('\\', '/', $classname);
        $filename = URL_ROOT . 'app/' . $classname .".php";
    }

    require_once($filename);

});

require_once( URL_CONTROLLERS.'conn.php') ; 
$_SESSION['bd'] = $_REQUEST['empresa'] ;

if ($conn->error == false ) {
    
    $confP = $conn->assoc('SELECT * FROM config ') ;
    $configCSS = $conn->assoc('SELECT * FROM config_css ') ;

    $conf = new core\Conexion( 'aol_accesos' ) ;
    $confG =  $conf->assoc( 'SELECT * FROM empresas WHERE id = '.$confP['idEmpresa'] .' LIMIT 1' );

   define('CONFIG' , array_merge($confG,$confP,$configCSS) );

} else {

    include ( URL_CONTROLLERS . 'error.php' ) ;
    exit ;
    
}
