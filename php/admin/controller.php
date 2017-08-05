<?php
if (strlen(session_id()) < 1) session_start ();

require_once ($_SERVER['DOCUMENT_ROOT'].'/php/connect/config.controller.php');
require_once  $_SERVER['DOCUMENT_ROOT']. '/php/libs/tools.php' ;

spl_autoload_register(
    function ( $nameClass ) {
        $explodes = explode('\\' , $nameClass) ; 
        $nameSpace = $explodes[0] ;
        $nameClass =  $explodes[1] ;
        $nameFile = strtolower($nameClass);

        include_once $nameFile . '/class.php';

    }  
);

if (isset($_GET['action'])){

    switch (trim($_GET['action'])){
        case 'main' :

            $fecha = $_GET['fecha'] ?? Date('Y-m-d');  
            require( 'core.php' ) ;        

        break ; 

    }
    require_once( $_GET['action'].'.php' ) ; 
}
