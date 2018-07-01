<?php
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

echo json_encode($r);