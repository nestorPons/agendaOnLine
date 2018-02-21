<?php namespace models;

if (!$_POST) exit;
$Create = new Create($_POST);
try {

    $Create->validateForm(); 
    $Create->ifCompanyExist();
    $Create->saveCompany();
    $Create->saveDb();
    $Create->createTables();
    $Create->createFolder();
    $Create->initializeCompany();

    // Esta constante se usa en la clase Conexion para conectar por defecto, si no se pasa ninguna base datos en los argumentos
    // Como paso por baseClass y no puedo pasarle la base datos hay que modificar la variable por defecto

    $_REQUEST['empresa'] = strtolower(trim($Create->nameCompany));
    require_once $url_base . 'app/conf/config.php' ;

    //Confirmacion por email hay que pasarle un objeto User
    $User = new User(1);
    $Mail = new Mail;
    $Mail->url_menssage = URL_SOURCES . 'mailactivate.php';
    $Mail->AltBody = 'Activar usuario: ' .  $User->token;
    $r['success'] = $Mail->send($User); 
    
    header('location: /create.company/'.$Create->$nameCompany);

} catch (\Exception $e){
    //die("Create Script => " . $e->getMessage() . " file => " . $e->getFile() .  " line => " . $e->getLine());
    header('location: /create.html?err='.$e->getMessage().'&cod='.$e->getCode());
}

