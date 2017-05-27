<?php
$mainconnection =  mysqli_connect('localhost',$user,$pass,"aol_accesos") 
	or die ("Error tools" . mysqli_error($result));

mysqli_set_charset($mainconnection, "utf8");
$result1 = mysqli_query($conn, "SELECT * FROM config");
$row1 = mysqli_fetch_assoc($result1);
$sql = "SELECT * FROM empresas WHERE empresas.Id = ".$row1['idEmpresa'];

$result2 = mysqli_query($mainconnection,$sql);
$row2 = mysqli_fetch_assoc($result2);	
$row = array_merge($row1,$row2);
define('CONFIG',$row);

//destroy
	mysqli_free_result($result1);
	mysqli_free_result($result2);
	unset($row,$config,$rowMain);
	mysqli_close($mainconnection);

include 'tools.php';
