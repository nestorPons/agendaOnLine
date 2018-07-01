<?php 
$arr = explode('/', $_SERVER['DOCUMENT_ROOT'] ) ;
define('URL_ROOT' , str_replace(array_pop($arr),'',$_SERVER['DOCUMENT_ROOT']) );

define('PUBLIC_FOLDER', URL_ROOT . 'htdocs' . '/');
define('APP_FOLDER', URL_ROOT . 'app'. '/');
define('URL_VENDOR' , APP_FOLDER .'vendor/' );
define('URL_AJAX' , APP_FOLDER .'models/ajax/' );
define('URL_CLASS' , APP_FOLDER .'models/class/' );
define('URL_CONTROLLERS' ,APP_FOLDER . 'controllers/' );
define('URL_CONFIG' , APP_FOLDER . 'conf/' );
define('URL_CORE' , APP_FOLDER . 'core/' );
define('URL_SQL' , APP_FOLDER . 'db/' );
define('URL_CSS' , PUBLIC_FOLDER . 'css/' );
define('URL_EMPRESAS' , PUBLIC_FOLDER .'empresas/' );
define('URL_JS' , PUBLIC_FOLDER . 'js/' );
define('URL_FUNCTIONS' , APP_FOLDER .'models/functions/' ); 
define('URL_SCRIPTS' , APP_FOLDER . 'models/scripts/' );
define('URL_SOURCES' , APP_FOLDER . 'sources/' );
define('URL_VIEWS' , APP_FOLDER . 'views/' );
    define('URL_TEMPLATES' , URL_VIEWS . 'templates/' );
    define('URL_VIEWS_ADMIN' , URL_VIEWS . 'admin/' );
    define('URL_VIEWS_USER' , URL_VIEWS . 'user/' );
    define('URL_MENUS' , URL_TEMPLATES . 'menus/' );

define('URL_PROTOCOL', 'https://');
define('URL_ABSOLUT', URL_PROTOCOL . $_SERVER['SERVER_NAME'] . '/');

const PREFIX_DB = 'rtc_'; 
const MARGIN_DAYS = 6;
const DEFAULT_HISTORY_DAYS = 1;
const NUM_MAX_ATTEMPT = 7; //attempts for crack brute force pass

// Constantes de desarrollo
const SAVE = 'save';
const DEL = 'del';
const EDIT = 'edit';
const GET = 'get';
const BR = '<br>';

const _NEW = -1; 

//datos de administrador
define ('ADMIN_WEB','https://www.reservatucita.com');
define ('ADMIN_NAME' , 'Nestor Pons') ; 
define ('ADMIN_EMAIL' , 'nestorpons@gmail.com') ; 