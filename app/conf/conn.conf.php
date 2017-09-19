<?php 

if (file_exists(URL_EMPRESAS . $_REQUEST['empresa'] )){

    return array(
        'server' => 'localhost',
        'user' => 'user', 
        'pass' => '0Z8AHyYDKN0hUYik',
        'db' => 'bd_' . $_REQUEST['empresa'], 
        'type' => 'mysql', 
    );

} else  {

    return false ;
    
}
 