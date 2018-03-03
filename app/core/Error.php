<?php namespace core ;

class Error {
    public static $last = false;

    const E000 = "Error inesperado";

    const E001 = "No se pudo crear la conexion a la base de datos" ;
    const E003 = "No se pudo guardar el registro";
    const E004 = "Registro duplicado";
    const E005 = "Error faltan datos";

    // Creando empresa
    const E011 = "Nombre ocupado" ;
    const E012 = "No se pudo validar los datos";
    const E013 = "No se pudo crear la base de datos";
    const E014 = "No se pudo crear las tablas";
    const E016 = "No se pudo inicializar las tablas";
    const E017 = "No se pudo crear el archivo de la empresa";

    //login 
    const E021 = "";
    const E022 = "Email ocupado."; 
    const E023 = "Estado usuario desactivado.";
    const E024 = 'Cuenta bloqueada. Consulte su administrador.';
    
    //nuevo usuario 
    const E025 = "";

    //Sessiones y times
    const E050 = "Se ha excedido el tiempo de sessión";
    const E010 = "Ha expirado la sessión" ;
    
    //Tokens 
    const E061 = "Su token ha expirado";
    const E062 = "Los tokens no coinciden";

    //Formularios
    const E030 = "Error guardando datos";
    const E031 = "Tamaño de datos incorrecto";

    //Base datos
    const E051 = "No se encontro la base de datos";

    //Mail 
    const E071 = "No se ha podido mandar el email";

	function __construct() {
        
    }
    public static function E010(){
       echo "error<SCRIPT>window.location='/".NAME_EMPRESA."?logout=true&err=".self::E010."';</SCRIPT>"; 
       return false;
    }
    public static function array($err){
        if (defined ('self::'.$err))
            return ['success'=>false , 'code' => $err , 'err' => constant('self::'.$err)] ;
        else
            return ['success'=>false , 'code' => 'E000' , 'err' => $err] ;
    }
    public static function set($err){
        self::$last = $err;
        return false;
    }
    public static function getLast(){
        $err = self::$last;
        self::$last = false;
        return $err;
    }
    public static function die($err = null){
        $err = $err??self::getLast();
        die(var_dump(self::array($err)));
    }
}