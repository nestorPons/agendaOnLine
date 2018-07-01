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
function sumarfecha($fecha,$num){
	$f = strtotime('+'.$num.' day',strtotime($fecha));
	$f = date('Y-m-d',$f);
	return $f;
 }

function delArray ($valor, &$arr){
    if (($key = array_search($valor, $arr)) !== false){
  		unset($arr[$key]);
    }

    return $arr;
 }
function compareArray ($arr1 ,$arr2) {
    $r['val'] = 0 ;
    $r['val'] += ($r['comp2'] = array_diff($arr2,$arr1))?1:0;
    $r['val'] += ($r['comp1'] = array_diff($arr1,$arr2))?2:0;
    
    /* 
        devuelve valor 
            0 = sin modificacion
            1 = cambios en  array 1
            2 = cambios en  array 2
            3 =  cambios en  array 1 y 2
    */
    return $r;
 }
function generateId( $f = null , $h = null , $a = null) { 

	$a = (!empty($a)) ? str_pad($a, 2, "0", STR_PAD_LEFT) : '';
	$f = substr(str_replace('-','',$f),0);
	$h = str_replace(':','',$h);
    
	$input =  $a . $f . $h ; 
    return str_pad($input,14,'0',STR_PAD_LEFT); 

 }