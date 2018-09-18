<?php
require_once URL_TEMPLATES . 'lstClientes.php';

$Horarios = new models\Horarios();
$_SESSION['HORAS'] =  $Horarios->hours();

$Servicios = new core\BaseClass('servicios') ;
$_SESSION['SERVICIOS'] = $Servicios->getAll('*',MYSQLI_NUM, 'descripcion');

$Fam = new core\BaseClass('familias') ;
$_SESSION['FAMILIAS'] = $Fam->getAll('*',MYSQLI_NUM, 'nombre') ;

$action =  $_REQUEST['action'] ?? 'main' ;

/* AKI 

$minifier = new Minify\JS( 
    URL_JS . 'main.js', 
    URL_JS . 'admin.js'
);
$minifier->minify(URL_JS . 'admin.min.js');
*/

require_once  URL_VIEWS_ADMIN . 'admin.php' ;        