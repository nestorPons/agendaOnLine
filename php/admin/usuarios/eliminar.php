<?php
header('Content-Type: application/json');
include "../../connect/conexion.php"; 
$conexion = conexion();

$sql="UPDATE  usuarios SET dateBaja = '". date('Y-m-d H:m:s') ."' WHERE Id =".$_GET['id'];
$jsondata['sql'] = $sql;
$jsondata['success'] =mysqli_query($conexion, $sql)?true:false;

foreach ( $_SESSION['USUARIOS'] as $key => $value ) {

    if ($_GET['id'] == $value[0] ){
        $key_id = $key ; 
        break;
    }

}

// 0 Id 1 Nombre 2 Email 3 Pass 4 Tel 5 Admin 6 Obs 7 cookie 8 Idioma 9 dateReg 10 dateBaja 11 Block

$_SESSION['USUARIOS'][$key_id][10] =  date('Y-m-d H:m:s');

//registrarEvento(2,0, $_GET['id'],0);
echo json_encode($jsondata);