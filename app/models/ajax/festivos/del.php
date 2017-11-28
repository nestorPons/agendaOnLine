<?php
header('Content-Type: application/json');

$js['success'] = $conn->query("DELETE FROM festivos WHERE Id = " . $_POST['id']); 
echo json_encode($js);