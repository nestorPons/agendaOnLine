<?php namespace models;
try {
    if (!$_POST) exit;
    $Create = new Create($_POST);
    $nameCompany =  $Create->getNameCompany();

    $Create->validateForm(); 
    $Create->ifCompanyExist();
    $Create->saveCompany();
    $Create->saveDb();
    $Create->createTables();
    $Create->createFolder();
    $Create->initializeCompany();

    $_REQUEST['empresa'] = strtolower(trim($nameCompany));
    require_once $url_base . 'app/conf/config.php' ;

    //Confirmacion por email hay que pasarle un objeto User
    $User = new User(1);
    $Mail = new Mail($User);
    $Mail->url_menssage = URL_SOURCES . 'mailactivate.php';
    $Mail->AltBody = 'Activar usuario: ' .  $User->token;
    $r['success'] = $Mail->send(); 
    include URL_VIEWS . 'createCompany.php' ;

} catch (\Exception $e){
    //die("Create Script => " . $e->getMessage() . " file => " . $e->getFile() .  " line => " . $e->getLine());
    header('location: /create.html?err='.$e->getMessage().'&cod='.$e->getCode());
}
