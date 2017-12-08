<?php namespace core;

if (!$_POST) exit;
$Create = new \models\Create($_POST);
try {
    $Create->validateForm(); 
    $Create->ifCompanyExist();
    $Create->saveCompany();
    $Create->saveDb();
    $Create->createTables();
    $Create->createFolder();
    $Create->initializeCompany();

    header('location: /'.$Create->$nameEmpresa);

} catch (\Exception $e){

    header('location: /create.html?err='.$e->getMessage().'&cod='.$e->getCode());

}

