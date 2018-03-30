<?php namespace core;

class Tools{
    function __construct(){}
    public static function getUserLanguage() {  
        $idioma =substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2); 
        return $idioma;  
     }
    public static function full_copy( $source, $target ) {
        try
        {
            if ( is_dir( $source ) ) {
                @mkdir( $target );
                $d = dir( $source );
                while ( FALSE !== ( $entry = $d->read() ) ) {
                    if ( $entry == '.' || $entry == '..' ) {
                        continue;
                    }
                    $Entry = $source . '/' . $entry;
                    if ( is_dir( $Entry ) ) {
                        full_copy( $Entry, $target . '/' . $entry );
                        continue;
                    }
                    copy( $Entry, $target . '/' . $entry );
                }
                $d->close();
                return true;
            }else {
                copy( $source, $target );
                return true;
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage();	
        }
     }
    public static function normalize($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
        ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
        bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = str_replace(' ', '', trim($cadena));
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
     }
    public static function normalizeShow($name){
        $name = str_replace('_', ' ', trim($name));
        $name = ucwords($name);
        return $name; 
     }
    public static function getIp() {
 
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }

     }
    public static function formatofecha($fecha){
		$a = explode('-',$fecha);
		$fecha = $a[2].'/'.$a[1].'/'.$a[0];
		return $fecha;
     }
    public static function encodeJSON($content){
        header('Content-Type: application/json');
         include_once $content;
        echo json_encode($r??false);
     }
    public static function printArray($arr){
        echo('<pre>');
            print_r($arr); 
        echo('</pre>');
     }
    
}