<?php
// Classes autoload OG
spl_autoload_register(function ($classname) {

    $arr_explode = explode("\\" , $classname) ; 
    $namespace = $arr_explode[0];
    $className = $arr_explode[1];

    if ( $namespace == 'models' ){
        $filename = URL_CLASS . $className . '.php' ;
    } else {
        $classname = str_replace ('\\', '/', $classname);
        $filename = URL_ROOT . 'app/' . $classname .".php";
    }

    require_once($filename);

});