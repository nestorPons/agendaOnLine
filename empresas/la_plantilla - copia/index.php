<?php 
$path = $_SERVER['PHP_SELF'];
$file = trim(dirname($path),"\/");
$nombre_empresa = ucwords(str_replace ("_"," ",$file));
include ('../php/index/index.php');