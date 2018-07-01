<?php namespace models;

$idUser = substr($_GET['args'],-4);
$User = new User($idUser);

if ($User->statusActive($_GET)) {
    header('location:'. URL_LOGIN .'?success=Usuario activado con exito');
} else {
    header('location:'. URL_LOGIN .'?error=' .\core\Error::$last);
}
