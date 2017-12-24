<?php

$url_font_main = "https://fonts.googleapis.com/css?family=" .
	str_replace(' ' ,'+' ,CONFIG['font_main']) ."|" . 
	str_replace(' ' ,'+' ,CONFIG['font_tile']) ; 
    
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title id = "loginTile" >agenda OnLine</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

        <link rel='shortcut icon' href='<?=URL_LOGO?>' >
        <link rel='shortcut icon' href='/img/favicon.ico' >
        <link rel="stylesheet"  type="text/css" href="/css/jquery-ui.min.css">
        <link rel="stylesheet"  type="text/css" href="/css/metro.css">
        <link rel="stylesheet"  type="text/css" href="/css/iconos.css">
        <link rel="stylesheet"  type="text/css" href="/css/main.css">
        <?php 
            if ($controller == 'login'){
                ?>
                <link rel="stylesheet"  type="text/css" href="/css/login.css">
                <?php
            }
        ?>
        <link rel="stylesheet"  type="text/css" href="/empresas/<?=NAME_EMPRESA?>/style.css">

        <link href="<?=$url_font_main?>" rel="stylesheet">
        <script  type="text/javascript" src="/js/start.js" async defer></script>
          