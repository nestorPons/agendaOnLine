<?php 

if ( $_POST ){
    
    $return = include URL_SCRIPTS . 'validar.php' ;

    if ( !empty($return['action']) ) {

        $args = isset($return['args']) ? '/' . $return['args'] :  '' ; 
        $action = $return['action'] . $args ;

    }

} else {

    $action = 'login' ;

}
header('Location: ' . $action);