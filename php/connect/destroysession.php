<?php 
if (isset($_SESSION)){
	// Borra todas las variables de sesión 
	$_SESSION = array();
	$_COOKIE = array();
	// Borra la cookie que almacena la sesión 
	setcookie("PHPSESSID","", time() - 3600);
	setcookie("marca","", time() - 3600, "/");
	setcookie("id_user","", time() - 3600, "/");
	setcookie(session_name(),"", time() - 3600, "/");
	// Finalmente, destruye la sesión 
	session_unset();
	session_destroy(); 
}