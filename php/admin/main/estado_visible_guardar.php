<?php
header('Content-Type: application/json');
require_once ($_SERVER['DOCUMENT_ROOT'].'/php/connect/conn.controller.php');

$sql = "UPDATE config SET ShowRow = ".$_GET['status'];
$data['success']=$conn->query($sql);
echo json_encode($data);