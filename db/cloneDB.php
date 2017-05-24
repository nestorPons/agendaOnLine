<?php
try
{
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "";
	$url = __DIR__;
/*
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE DATABASE IF NOT EXISTS bd_$bd DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

  // use exec() because no results are returned
  $conn->exec($sql);
*/
  // comandos a ejecutar
  //$command = "mysqldump  --user=$username --password=$password bd_la_plantilla --no-data > plantilla.sql";
  // ejecución y salida de éxito o errores
  //exec($command,$output);
	$command = "mysqldump  --user=$username --password=$password --debug-check bd_la_One < plantilla.sql";
  // ejecución y salida de éxito o errores

  system($command,$output);

	print_r($output);
}
catch(PDOException $e)
  {
    echo $e->getMessage();
  }
