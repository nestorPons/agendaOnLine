<?php 
function destroySession(){
	// Borra todas las variables de sesión 
	$_SESSION = array();
	$_COOKIE = array();
	// Borra la cookie que almacena la sesión 
	setcookie("PHPSESSID","", time() - 3600);
	setcookie("marca","", time() - 3600, "/");
	setcookie("id_user","", time() - 3600, "/");
	// Finalmente, destruye la sesión 
	session_destroy(); 
}
function diasTranscurridos($f1,$f2){
	$d = (strtotime($f1)-strtotime($f2))/86400;
	$d = abs($d);
	$d = floor($d);
	return $d;
}
function getMonthDays($Month, $Year){
   //Si la extensión que mencioné está instalada, usamos esa.
   if( is_callable("cal_days_in_month")){
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
   } else {
      //Lo hacemos a mi manera.
      return date("d",mktime(0,0,0,$Month+1,0,$Year));
   }
}
function registrarEvento($idEven, $idCita, $idUsuario,$agenda){
	global $conexion;
	$fechaEvento 	= date("Y-m-d H:i:s");
	$admin = (empty($_SESSION['admin_sesion']))?0:1;
	$idUsuario = $idUsuario??-1;
	$idUsuario = $_SESSION['id_usuario']??$idUsuario;
	
	$SQL = "INSERT INTO even (IdUsuario,IdCita, IdEven, Fecha, Admin,agenda) 
	VALUE ($idUsuario, $idCita,'$idEven','$fechaEvento',$admin,$agenda)";
	 return mysqli_query($conexion,$SQL);
}
function normaliza($cadena){
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
function formatoFecha($fecha,$separador){
		$a = explode('-',$fecha);
		$fecha = $a[2].'/'.$a[1].'/'.date('Y');
		return $fecha;
}
function sumarFecha($fecha,$num){
	$f = strtotime('+'.$num.' day',strtotime($fecha));
	$f = date('Y-m-d',$f);
	return $f;
}
