<?php
header('Content-Type: application/json');
require "../../connect/conn.controller.php";

$js['success'] = $conn->query("DELETE FROM festivos WHERE Id = " . $_GET['id']); 
echo json_encode($js);