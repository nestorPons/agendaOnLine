<?php
use MatthiasMullie\Minify;
header('Content-Type: application/json');

$conf_css = new \core\BaseClass('config_css');

$args = [
    'color_main' => $_POST['color1'],
    'color_secon' => $_POST['color2'],
    'border_radio' => $_POST['border']??2 , 
    'font_main' => $_POST['text1']??'Roboto' , 
    'font_tile' => $_POST['text2']??'Raleway'
 ];

$r['success'] = $conf_css->saveAll($args);

if ($config = $conf_css->getAll()){
    $url_css = URL_EMPRESA . "style.css";
    unlink($url_css);

    $url_less = URL_EMPRESA . "style.less";

    require_once( URL_FUNCTIONS . 'compilaLess.php') ; 
    compilaLess($url_css,$url_less);

}

require_once URL_LIB . 'minify/src/Minify.php';
require_once URL_LIB . 'minify/src/CSS.php';
require_once URL_LIB . 'minify/src/JS.php';
require_once URL_LIB . 'minify/src/Exception.php';
require_once URL_LIB . 'minify/src/Exceptions/BasicException.php';
require_once URL_LIB . 'minify/src/Exceptions/FileImportException.php';
require_once URL_LIB . 'minify/src/Exceptions/IOException.php';
require_once URL_LIB . 'path-converter/src/ConverterInterface.php';
require_once URL_LIB . 'path-converter/src/Converter.php';

$minifier = new Minify\CSS( 
    URL_CSS . 'jquery-ui.min.css',
    URL_CSS . 'metro.css', 
    URL_CSS . 'iconos.css',
    URL_CSS . 'font.css',
    URL_CSS . 'main.css',
    URL_CSS . 'login.css',
    "empresas/{$Empresa->code()}/style.css"
);
$minifier->minify(URL_CSS . 'main_dinamic.min.css'); 


echo json_encode($r);