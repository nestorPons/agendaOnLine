<?php 
// Constantes de desarrollo
const PREFIX_DB = 'rtc_'; 

const SAVE = 'save';
const ADD = 'add';
const DEL = 'del';
const EDIT = 'edit';
const GET = 'get';
const BR = '<br>';

$arr = explode('/', $_SERVER['DOCUMENT_ROOT'] ) ;
define('URL_ROOT' , str_replace(array_pop($arr),'',$_SERVER['DOCUMENT_ROOT']) );

define('PUBLIC_FOLDER', URL_ROOT . 'htdocs/agenda/');
define('APP_FOLDER', URL_ROOT . 'app_agenda/');
define('URL_LIB' , APP_FOLDER .'lib/' );
define('URL_VENDOR' , APP_FOLDER .'vendor/' );
define('URL_AJAX' , APP_FOLDER .'models/ajax/' );
define('URL_CLASS' , APP_FOLDER .'models/class/' );
define('URL_CONTROLLERS' ,APP_FOLDER . 'controllers/' );
define('URL_CONFIG' , APP_FOLDER . 'conf/' );
define('URL_CORE' , APP_FOLDER . 'core/' );
define('URL_SQL' , APP_FOLDER . 'db/' );
define('URL_CSS' , PUBLIC_FOLDER . 'css/' );
define('URL_IMG' , PUBLIC_FOLDER .'img/' );
define('URL_EMPRESAS' , PUBLIC_FOLDER .'empresas/' );
define('URL_JS' , PUBLIC_FOLDER . 'js/' );
define('URL_FUNCTIONS' , APP_FOLDER .'models/functions/' ); 
define('URL_SCRIPTS' , APP_FOLDER . 'models/scripts/' );
define('URL_VIEWS' , APP_FOLDER . 'views/' );
    define('URL_TEMPLATES' , URL_VIEWS . 'templates/' );
    define('URL_VIEWS_ADMIN' , URL_VIEWS . 'admin/' );
    define('URL_VIEWS_USER' , URL_VIEWS . 'user/' );
    define('URL_MENUS' , URL_VIEWS . 'menus/' );
    define('URL_EMAILS' , URL_TEMPLATES . 'emails/' );

define('URL_PROTOCOL', 'https://');
define('URL_ABSOLUT', URL_PROTOCOL . $_SERVER['SERVER_NAME'] . '/');