<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/php/connect/config.controller.php');
if ($_GET){
    if ($_GET['status']){
        $sql = "UPDATE config SET ShowRow = ".$_GET['status'];
        $data['success']=$conn->query($sql);
    }
}