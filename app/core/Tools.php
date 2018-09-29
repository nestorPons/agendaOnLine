<?php namespace core;

class Tools{
    function __construct(){}
    public static function current_date($format = 'Y-m-d H:i:s'){
        return date($format);
     }
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
    public static function get_content(...$args){
        
        ob_start(); # apertura de bufer
        include( $args[0] );
        $begin = ob_get_contents();
        ob_end_clean(); # cierre de bufer

        return $begin;
     }
    public static function strToUrl($str){
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð',
            'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã',
            'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ',
            'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ',
            'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę',
            'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī',
            'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ',
            'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ',
            'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť',
            'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ',
            'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ',
            'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O',
            'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c',
            'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
            'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D',
            'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
            'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K',
            'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
            'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S',
            's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W',
            'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i',
            'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        $str = str_replace($a, $b, $str);
	    $str = str_replace(' ', '%20', $str);
	    return $str;
     }
    public static function generateId( $f = null , $h = null , $a = null) { 

        $a = (!empty($a)) ? str_pad($a, 2, "0", STR_PAD_LEFT) : '';
        $f = substr(str_replace('-','',$f),0);
        $h = str_replace(':','',$h);
        
        $input =  $a . $f . $h ; 
        return str_pad($input,14,'0',STR_PAD_LEFT); 
    
     }
    public static function minifierJS($args){
        try{
            require_once URL_LIB . 'minify/src/Minify.php';
            require_once URL_LIB . 'minify/src/CSS.php';
            require_once URL_LIB . 'minify/src/JS.php';
            require_once URL_LIB . 'minify/src/Exception.php';
            require_once URL_LIB . 'minify/src/Exceptions/BasicException.php';
            require_once URL_LIB . 'minify/src/Exceptions/FileImportException.php';
            require_once URL_LIB . 'minify/src/Exceptions/IOException.php';
            require_once URL_LIB . 'path-converter/src/ConverterInterface.php';
            require_once URL_LIB . 'path-converter/src/Converter.php';
            
            $minifier = new \MatthiasMullie\Minify\JS(); 
            if(is_array($args)){
                $name = $args[0]; 
                foreach($args as $val){
                    $minifier->add(URL_JS .$val.'.js');
                }
            }else{ 
                $name = $args; 
                $minifier->add(URL_JS . $args.'.js');
            }
            $minifier->minify(URL_JS . 'min/' . $name .'.js' );
        } catch (Exception $e){
            echo 'error minifier.js';
            echo $e->getMessage();
        }
    }
}