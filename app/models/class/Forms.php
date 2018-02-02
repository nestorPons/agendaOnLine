<?php namespace models;

class Forms{ 
    const ISINT = 1 , ISBOOL = 2, ISSTR = 3, ISDATE = 4, ISEMAIL = 5, ISHOUR = 6, ISFLOAT= 7, ISCOL = 8;
    private  $rules =  [
        'admin'         => [self::ISBOOL,1,1],
        'agenda'        => [self::ISINT,2,1],
        'action'        => [self::ISSTR,7,1],
        'ancho'         => [self::ISINT,5, 1],
        'auth'          => [self::ISSTR,70,60],
        'baja'          => [self::ISBOOL,1,1],
        'border'        => [self::ISINT,2,1],  
        'cliente'       => [self::ISINT,5,1],  
        'codigo'        => [self::ISSTR,6,1],
        'controller'    => [self::ISSTR,16,3],
        'color1'        => [self::ISCOL,7,7],
        'color2'        => [self::ISCOL,7,7],
        'cp'            => [self::ISINT,7,3],
        'days'          => [self::ISINT,2,1],
        'descripcion'   => [self::ISSTR,30,3],
        'id'            => [self::ISINT,11,1],
        'idEmpresa'     => [self::ISINT,4,1], 
        'idUser'        => [self::ISINT,5,1],
        'idFamilia'     => [self::ISINT,5,1],  
        'dir'           => [self::ISSTR,50,4],
        'dni'           => [self::ISSTR,10,7],
        'email'         => [self::ISEMAIL,50,6],
        'login'         => [self::ISEMAIL,50,6],
        'fecha'         => [self::ISDATE,10,6],
        'festivosON'    => [self::ISBOOL,1,1],
        'hora'          => [self::ISHOUR,10,4],
        'minTime'       => [self::ISINT,3,1],
        'nombre'        => [self::ISSTR,50,3],
        'nota'          => [self::ISSTR,500,0],
        'obs'           => [self::ISSTR,500,0],
        'pais'          => [self::ISSTR,30,3],
        'pass'          => [self::ISSTR,130,0],
        'pinpass'       => [self::ISINT,4,4], 
        'poblacion'     => [self::ISSTR,30,3],
        'precio'        => [self::ISINT,4,0], 
        'provincia'     => [self::ISSTR,30,3],
        'recordar'      => [self::ISBOOL,1,1],
        'sendMailUser'  => [self::ISBOOL,1,1],
        'status'        => [self::ISBOOL,6,1],
        'showInactivas' => [self::ISBOOL,1,1],
        'servicios'     => [self::ISINT,2,1],
        'sector'        => [self::ISSTR,30,3],
        'tel'           => [self::ISSTR,15,0],
        'text1'         => [self::ISSTR,30,3],
        'text2'         => [self::ISSTR,30,3],
        'tiempo'        => [self::ISINT,4,1],
        'tiempoTotal'   => [self::ISFLOAT,3,1], 
        'token'         => [self::ISSTR,45,40],
        'utiempo'       => [self::ISFLOAT,20,0], 
        'view'          => [self::ISSTR,15,4],
        'web'           => [self::ISSTR,50,1]
     ];
    function __construct(){}
    public static function isDate($strDate){
        $arr = explode('-',$strDate);
        if (!isset($arr[1])){
            $arr[0] = substr($strDate,0,4);
            $arr[1] = substr($strDate,4,2);
            $arr[2] = substr($strDate,6);
        }
        return checkdate($arr[1],$arr[2],$arr[0]);       
     }
    public static function isHour($strHour){
        if (preg_match('/^[0-9]{2}:[0-9]{2}$/', $strHour)){
            $h = substr("$strHour", 0,2);
            $m = substr("$strHour", 3,2);
            return ($h <= "23") OR ($m <= "59");
        } else return false;
     }
    public static function sanitize($post){
        if (empty($post)) die(Error::E005);

        if(isset($post['controller'])) unset($post['controller']);
        if(isset($post['action'])) unset($post['action']);
        return $post;
     }
    private function  switchRules($key, $value, $exceptions =[]){

        foreach ($this->rules as $kRule => $vRule){
            if (stristr($key,$kRule)){
                $len = strlen($value);

                if($len>$vRule[1] || $len<$vRule[2]) return \core\Error::set('E031');

                switch($vRule[0]){
                    case self::ISSTR:
                        return true;
                    case self::ISCOL:
                        return substr($value, 0, 1) == '#';
                    case self::ISINT:
                        return  preg_match("/^[0-9]+$/",$value);//(filter_var($value, FILTER_VALIDATE_INT));
                    case self::ISFLOAT:
                        return (filter_var($value, FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION));
                    case self::ISDATE:
                        return ($this->isDate($value));
                    case self::ISEMAIL:
                        return (filter_var($value, FILTER_SANITIZE_EMAIL));
                    case self::ISHOUR:
                        return ($this->isHour($value));
                    case self::ISBOOL:
                        return (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)!==null);
                }          
                break;
            }
        }
        
     }
    public function validateForm ($post,$exceptions = []){

        foreach($post as $key => $value){
            if (is_array($value)) { 
                foreach($value as $k => $val){
                    if(!$this->switchRules($key, $val, $exceptions)) return \core\Error::set($k);
                }
            } else {
                if(!$this->switchRules($key, $value, $exceptions)) return \core\Error::set($key);
            }        
        }
        return true;
     }  
 }