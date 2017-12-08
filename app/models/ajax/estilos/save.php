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

$r = $conf_css->saveAll($args );

if ($config = $conf_css->getByAll()){

    $inputFile = URL_EMPRESA . "style.less";
    $outputFile = URL_EMPRESA . "style.css";

    $less = new \models\Lessc;
    $less->arrPHP = $config;

    // create a new cache object, and compile
    $cache = $less->cachedCompile($inputFile);

    file_put_contents($outputFile, $cache["compiled"]);

    // the next time we run, write only if it has updated
    $last_updated = $cache["updated"];
    $cache = $less->cachedCompile($cache);
    if ($cache["updated"] > $last_updated) {
        file_put_contents($outputFile, $cache["compiled"]);
    }

}

echo json_encode($r);