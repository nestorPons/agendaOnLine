<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$sql="UPDATE  usuarios SET dateBaja = '". date('Y-m-d H:m:s') ."' WHERE Id =".$_GET['id'];
$jsondata['success'] =$conn->query($sql);

foreach ( $_SESSION['USUARIOS'] as $key => $value ) {

    if ($_GET['id'] == $value[0] ){
        $key_id = $key ; 
        break;
    }

}

// 0 Id 1 nombre 2 Email 3 Pass 4 Tel 5 Admin 6 obs 7 cookie 8 Idioma 9 dateReg 10 dateBaja 11 Block

$_SESSION['USUARIOS'][$key_id][10] =  date('Y-m-d H:m:s');

//registrarEvento(2,0, $_GET['id'],0);
echo json_encode($jsondata);