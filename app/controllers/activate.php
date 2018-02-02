<?php namespace models;

$idUser = substr($_GET['args'],-4);
$User = new User($idUser);

if ($User->activate($_GET)) {
    header('location:'. URL_LOGIN .'?success=Usuario activado con exito');
} else {
    echo 'error=>' . \core\Error::$last;
}
