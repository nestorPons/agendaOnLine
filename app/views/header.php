<!DOCTYPE html>
<html lang="es">
    <head>
        <title id = "loginTile">agenda OnLine</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        
        <!-- quita css de seleccion en explorer!-->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- quita barra navegacion!-->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Chrome, Firefox OS, Opera and Vivaldi -->
        <meta name="theme-color" content="<?= CONFIG['color_main']?>"> 
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="<?= CONFIG['color_main']?>">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="<?= CONFIG['color_main']?>">
        <!--  manifest -->    
        <link rel="manifest" href="/manifest.json.php?nombre_empresa=<?=CONFIG['nombre_empresa']?>&color_main=<?= substr(CONFIG['color_main'],1)?>">
        
        <!--favicon-->
        <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
        <link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <link rel="stylesheet" href="<?=$url_font_main?>" >

        <!--
        <link rel="stylesheet"  type="text/css" href="/css/jquery-ui.min.css">
        <link rel="stylesheet"  type="text/css" href="/css/metro.css">
        <link rel="stylesheet"  type="text/css" href="/css/iconos.css">
        <link rel="stylesheet"  type="text/css" href="/css/font.css">
        <link rel="stylesheet"  type="text/css" href="/css/main.css">
        <link rel="stylesheet"  type="text/css" href="/css/login.css">
        <link rel="stylesheet"  type="text/css" href="/empresas/<?=$Empresa->code()?>/style.css">
        <script  src="/js/index.min.js" async></script>
        <script  src="/js/service-worker/registration.min.js" async></script>
        -->
        <link rel="stylesheet"  type="text/css" href="/css/index.min.css">
        <script  src="/js/main.js" ></script>

      
        <!-- AKI:: hay que quitar esto del login-->
        <script>
            let config = new Object;
            config = <?=json_encode (CONFIG)?>;
            config.festivos = <?=json_encode (FESTIVOS)?>;
            config.horarios = <?=json_encode($_SESSION['HORAS']??null)?>;
            config.margenDias  = <?=MARGIN_DAYS?>;	
            </script>
        <!-- para produccioon
    -->
         
        
<!-- Fuerza a la no lectura de cache-->
<meta http-equiv="Expires" content="0">

<meta http-equiv="Last-Modified" content="0">

<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">

<meta http-equiv="Pragma" content="no-cache">


