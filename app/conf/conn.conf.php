<?php 

if (file_exists(URL_EMPRESA)){

    return array(
        'server' => 'localhost',
        'user' => 'user', 
        'pass' => '0Z8AHyYDKN0hUYik',
        'db' => NAME_DB, 
        'type' => 'mysql', 
    );

} else  {

    return false ;
    
}
 