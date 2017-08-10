<?php
//Tiene que estar activo el modulo pdo_mysql  y editar php.ini 
header('Content-Type: application/json');
if (empty($_POST['empresa'])||empty($_POST['email']))error('Faltan datos');
if (!validarPass()) error('Passwords incorrectos');

$jsondata['success'] = true;
$empresa = $_POST['empresa'];

$source ='../la_plantilla';
$destination = '../'. limpia_espacios($empresa)."/";

if (!file_exists($destination)){
	$creaEmpresa = add_db($empresa);
	if($creaEmpresa){
		full_copy($source, $destination);
		$jsondata['success']=true;
	}else{
		error('ERROR=>'.$creaEmpresa);
	}
}else{
	error(1);
}
function add_db($bd){
	$empresa = $bd;
	$bd =  "bd_".limpia_espacios($bd);
	$servername = "localhost";
	$username = "create";
	$password = "JDrgz3GeIblO40g0";
	$dbname = "";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE DATABASE IF NOT EXISTS $bd DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

		// use exec() because no results are returned
		$conn->exec($sql);

		// comandos a ejecutar
		$command = "mysqldump  -u $username -p$password bd_la_plantilla | mysql -u $username -p$password -D $bd";
		// ejecución y salida de éxito o errores
		system($command,$output);

		if($output==0){
			$nom =  trim($_POST['nombre']);
			$nif = $_POST['nif']??"";
			$dir =  $_POST['dir']??"";
			$poblacion =  trim($_POST['poblacion'])??"";
			$cp =  $_POST['cp']??"";
			$email =  trim($_POST['email']);
			$web =  trim($_POST['web'])??"";
			$tel =  $_POST['tel']??"";
			$sector =  $_POST['sector']??1;
			$pass = $_POST['pass1'];
			$fecha = date("Y-m-d H:i:s");
			$idioma = "ES";
			
			$conexion =  mysqli_connect($servername,$username,$password, "aol_accesos") or error("Error de conexion a aol_accesos");
			$sql = "INSERT INTO empresas (nombre,NIF,NomUser,Dir,Poblacion,Pais,CP,Email,Web,Tel,fecha,Sector,Idioma,Plan,NumAg,horarios,UltimoAcceso) 
				VALUE ('$empresa','$nif','$nom','$dir','$poblacion','','$cp','$email','$web','$tel','$fecha',$sector,'$idioma',1,1,1,'". date("d-m-Y H:i:s")."');";
			if (mysqli_query($conexion,$sql)){
				$id = mysqli_insert_id($conexion);
				$con =  mysqli_connect($servername,$username,$password,$bd) or die (error(mysqli_error($con)));
				
				//Todas las consultas para inicializar las tablas que vienen por defecto
				
				$sql = "INSERT INTO usuarios (nombre,Email,Pass,Tel,Admin,dateBaja)
				VALUE ('$nom','$email','$pass','$tel',1,'$fecha');";
				$sql.= "INSERT INTO config (idEmpresa) VALUE ($id);";
				$sql.= "INSERT INTO config_css () VALUES ();";
				
				return mysqli_multi_query($con,$sql)??error($sql);
				
			}else{error($sql);}
		}else{error("error mysqldump =>".$output);}
	}
	catch(PDOException $e){
		error ($e->getMessage());
	}
	$conn = null;
}
function full_copy( $source, $target ) {
	try
	{
		if ( is_dir( $source ) ) {
			@mkdir( $target );
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry;
				if ( is_dir( $Entry ) ) {
					full_copy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
			$d->close();
		}else {
			copy( $source, $target );
		}
	}
	catch (Exception $e)
	{
		$jsondata['copy_folder'] = $e->getMessage();	
	}
}
function error($mns){
	$jsondata['success'] = false;
	$jsondata['error'] = $mns;
	echo json_encode($jsondata);
	exit;
}
function validarPass(){
	$pass1 = $_POST['pass1']??null;
	$pass2 = $_POST['pass2']??null;
	return $pass1===$pass2;
}
function limpia_espacios($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
	ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
	bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	$cadena = str_replace(' ', '_', trim($cadena));
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}
echo json_encode($jsondata);