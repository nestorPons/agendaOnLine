<?php 
$arr = explode('/', $_SERVER['DOCUMENT_ROOT'] ) ;
define('URL_ROOT' , str_replace(array_pop($arr),'',$_SERVER['DOCUMENT_ROOT']) );

define('NAME_EMPRESA' , strtolower(trim($_REQUEST['empresa'])) );
    define('NAME_DB' , 'bd_' . NAME_EMPRESA );
define('URL_AJAX' , URL_ROOT . 'app/models/ajax/' );
define('URL_CLASS' , URL_ROOT . 'app/models/class/' );
define('URL_CONTROLLERS' , URL_ROOT . 'app/controllers/' );
define('URL_CONFIG' , URL_ROOT . 'app/conf/' );
define('URL_CORE' , URL_ROOT . 'app/core/' );
define('URL_CSS' , URL_ROOT . 'web/css/' );
define('URL_EMPRESAS' , URL_ROOT . 'web/empresas/' );
    define('URL_EMPRESA' , URL_EMPRESAS . NAME_EMPRESA . '/' );
define('URL_JS' , URL_ROOT . 'web/js/' );
define('URL_FUNCTIONS' ,  URL_ROOT . 'app/models/functions/' ); 
define('URL_SCRIPTS' , URL_ROOT . 'app/models/scripts/' );
define('URL_SOURCES' , URL_ROOT . 'app/sources/' );
define('URL_VIEWS' , URL_ROOT . 'app/views/' );
    define('URL_TEMPLATES' , URL_VIEWS . 'templates/' );
    define('URL_VIEWS_ADMIN' , URL_VIEWS . 'admin/' );
    define('URL_VIEWS_USER' , URL_VIEWS . 'user/' );
    define('URL_MENUS' , URL_TEMPLATES . 'menus/' );
define('URL_LOGO' , getLogo());
define('CLASS_BACKGROUND' , backgroundImage());
define('NUM_MAX_ATTEMPT', 5); //attempts for crack brute force pass

function getLogo () {
   return file_exists(URL_EMPRESA."logo.png")?'/empresas/'.NAME_EMPRESA."/logo.png":"img/logo.png" ;
}

function backgroundImage() {
	return file_exists( URL_EMPRESA ."background.jpg")?"background-personalized": "background" ;
}