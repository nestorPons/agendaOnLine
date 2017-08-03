<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$sql='UPDATE articulos  SET Baja = 1 WHERE id='.$_GET['id'] .' LIMIT 1;';
$r['success'] =$conn->query($sql);

foreach ( $_SESSION['SERVICIOS'] as $key => $value ) {

    if ($_GET['id'] == $value[0] ){
        $key_id = $key ; 
        break;
    }

}	
//	0 Id 1 Codigo 2 Descripcion 3 Precio 4 Tiempo 5 IdFamilia 6 Baja
$_SESSION['SERVICIOS'][$key_id][6]  =  '1' ;
$r[$key_id] = $_SESSION['SERVICIOS'][$key_id]  ;
echo json_encode($r);