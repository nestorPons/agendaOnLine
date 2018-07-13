<?php
$url_font_main = "https://fonts.googleapis.com/css?family=" .
	str_replace(' ' ,'+' ,CONFIG['font_main']) ."|" . 
	str_replace(' ' ,'+' ,CONFIG['font_tile']) ; 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title id = "loginTile">agenda OnLine</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

        <!-- Chrome, Firefox OS, Opera and Vivaldi -->
        <meta name="theme-color" content="<?= CONFIG['color_main']?>"> 
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="<?= CONFIG['color_main']?>">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="<?= CONFIG['color_main']?>">

        <link rel='shortcut icon' href='<?=URL_LOGO?>' >
        <link rel='shortcut icon' href='/img/favicon.ico' >
       
        <link rel="stylesheet"  type="text/css" href="/css/jquery-ui.min.css">
        <link rel="stylesheet"  type="text/css" href="/css/metro.css">
        <link rel="stylesheet"  type="text/css" href="/css/iconos.css">
        <link rel="stylesheet"  type="text/css" href="/css/font.css">
        <link rel="stylesheet"  type="text/css" href="/css/main.css">
        <?php 
            if ($controller == 'login'){
                ?>
                <link rel="stylesheet"  type="text/css" href="/css/login.css">
                <?php
            }
        ?>
        <link rel="stylesheet"  type="text/css" href="/empresas/<?=CODE_EMPRESA?>/style.css">
        <link rel="stylesheet" href="<?=$url_font_main?>" >
   
        <script  src="/js/start.js" async></script>
          