<?php
if (strlen(session_id()) < 1){ session_start (); }

require_once( URL_CONFIG . 'conn.conf.php' ); 

$conn = new core\Conexion;

if ( $_REQUEST ) {
    foreach ($_REQUEST as $key => $value) {

        if (is_array($value)){
            foreach ( $value as $k => $val ) { 
                if (is_array($val)){
                    foreach ( $val as $h => $v ) { 
                        
                         $_REQUEST[$key][$k][$h] = $conn->scape($v) ;

                    }

                }else{

                     $_REQUEST[$key][$k] = $conn->scape($val) ;

                }

            }

        }else{
   
            $_REQUEST[$key] = $conn->scape($value) ;

        }

    }
}
