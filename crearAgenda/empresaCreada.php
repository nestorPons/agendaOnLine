<?php 
$link = $_SERVER['SERVER_NAME']."/".$_GET["e"]."/index.php";

?>
<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Metro, a sleek, intuitive, and powerful framework for faster and easier web development for Windows Metro Style.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, metro, front-end, frontend, web development">
    <meta name="author" content="Sergey Pimenov and Metro UI CSS contributors">

    <link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

    <title>Login form :: Metro UI CSS - The front-end framework for developing projects on the web in Windows Metro Style</title>
	 <link href="css/estilos.css" rel="stylesheet">
    <link href="css/metro.min.css" rel="stylesheet">
	<script  type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
	<script  type="text/javascript" src="js/jquery-ui.min.js" async></script>
 
    <script>
        $(function(){
			$('.btn-danger').click(function(){window.location.href = "index.html"})
			
			var form = $(".login-form");
			form.css({
				opacity: 1,
				"-webkit-transform": "scale(1)",
				"transform": "scale(1)",
				"-webkit-transition": ".5s",
				"transition": ".5s"
			});
			$('.icon-cancel').click(function(){
				$(this).parent().find('input').val("");
			})
			$('.icon-eye').click(function(){
				var tipo = $(this).siblings('input').attr('type')
				tipo = tipo == 'password'?'text':'password';
				$(this).siblings('input').attr('type',tipo)
			})
			$('.btnLoad').click(function(){
				if($('form')[0].checkValidity())
				$(this).html('<span class="icon-load animate-spin"></span>')			
			})
		});
    </script>
</head><body>
    <div class="login-form padding20 block-shadow">
		<h1 class="text-light">Empresa creada</h1>
		<hr class="thin"/>
		<br>
		<span>Ya tiene creada la empresa.</span><br>
		<span> A partir de ahora siempre que quiera dirigirse a su Agenda OnLine acceda a la siguiente direccion:</span>
		<div class="margin10">
			<a  href="<?php  echo  $_GET["e"]."/"?>"><?php  echo$link?></a>
		</div>
	</div>
</body></html>