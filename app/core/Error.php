<?php namespace core ;

class Error {
    const E001 = "No se pudo crear la conexion a la base de datos" ;
    const E003 = "No se pudo guardar el registro";
    const E004 = "Registro duplicado";
    
    // Errores create
    const E011 = "Nombre ocupado" ;
    const E012 = "No se pudo validar el formulario";
    const E013 = "No se pudo crear la base de datos";
    const E014 = "No se pudo crear las tablas";
    const E016 = "No se pudo inicializar las tablas";
    const E017 = "No se pudo crear el archivo de la empresa";

    //login 
    const E021 = "";

    //Formularios
    const E030 = "Error guardando datos";
	function __construct( ) {
    
    
    }

}