<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$color1 = $_POST['color1'];
$color2 = $_POST['color2'];
$border = $_POST['border']??2;
$font = $_POST['text1']??'Roboto';
$fontTile = $_POST['text2']??'Raleway';

$sql = "UPDATE config_css SET color_main ='$color1', color_secon ='$color2' , border_radio ='$border' , font_main = '$font', font_tile = '$fontTile'" ;
$data = $conn->query($sql) ;


if ($config = $conn->assoc("SELECT * FROM config_css")){
    include("../../../css/lessc.inc.php") ;

    $url_empresa = "../../../empresas/".$_SESSION['bd']."/";
    $inputFile = $url_empresa."estilos.less";
    $outputFile = $url_empresa."estilos.css";


    $less = new lessc;
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

echo json_encode($data);