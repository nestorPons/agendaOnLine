<?php
if (strlen(session_id()) < 1) session_start ();

include $_SERVER['DOCUMENT_ROOT'].'/php/connect/conn.class.php' ; 

$conn = new connect\Conexion( 'bd_'. $_SESSION['bd'] );

if ( $_POST ) {
    foreach ($_POST as $key => $value) {
  
        if (is_array($_POST[$key])){
 
            $_POST[$key][] = $conn->scape($value) ;

        }else{
   
            $_POST[$key] = $conn->scape($value) ;

        }

    }
}
if ( $_GET ) {
    foreach ($_GET as $key => $value) {
  
        if (is_array($_GET[$key])){
 
            $_GET[$key][] = $conn->scape($value) ;

        }else{
   
            $_GET[$key] = $conn->scape($value) ;

        }

    }
}