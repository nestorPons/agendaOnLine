<?php 
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
function formatofecha($fecha){
		$a = explode('-',$fecha);
		$fecha = $a[2].'/'.$a[1].'/'.$a[0];
		return $fecha;
}
function sumarfecha($fecha,$num){
	$f = strtotime('+'.$num.' day',strtotime($fecha));
	$f = date('Y-m-d',$f);
	return $f;
}
//FESTIVOS
function festivos(){
	global $conn;
	$row = $conn->all("SELECT fecha FROM festivos") ;
	
	$count =  count($row) ;

	for ($i = 0 ; $i < $count ; $i++ ){

		$r = (is_array($row[$i]))?$row[$i][0]:$row[$i] ;

		$date =new DateTime($r);
		$date = date_format($date,"md");
		$data['festivos'][]=$date;	

	}

	return $data['festivos']??false;
}