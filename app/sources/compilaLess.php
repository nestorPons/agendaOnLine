<?php 
//Compilando la hoja de estilos
$url_css = URL_EMPRESA . "style.css";
$url_less = URL_EMPRESA . "style.less";

require_once( URL_FUNCTIONS . 'compilaLess.php') ; 
compilaLess($url_css,$url_less);
//************************************