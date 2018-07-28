<?php 
// variable $nameCompany declarada en script create. 
$link = $_SERVER['SERVER_NAME']."/".$nameCompany."/index.php";
?>
<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Metro, a sleek, intuitive, and powerful framework for faster and easier web development for Windows Metro Style.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, metro, front-end, frontend, web development">
	<meta name="author" content="Sergey Pimenov and Metro UI CSS contributors">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="css/pigendo.css" type="text/css">
	<link rel="stylesheet" href="css/metro.css" type="text/css">
	
    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico' />

    <title>Login form :: Metro UI CSS - The front-end framework for developing projects on the web in Windows Metro Style</title>
	 <link href="/css/main.css" rel="stylesheet">

	<script  type="text/javascript" src="/js/jquery.min.js" async></script>
 
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
			})
		});
	</script>
	<style>
		.login-form{
			text-align: justify
		}
	</style>
</head><body>
    <div class="login-form padding20 block-shadow">
		<h1>Empresa creada</h1>
		<hr class="thin"/>
		<br>
		<span>Se creó la empresa correctamente.</span><br>
		<p>Debe seguir las instrucciones del correo electronico que le hemos enviado</p>
		<p>Si no lo encuentra en su bandeja de entrada revise la carpeta de spam</p>
		<span> A partir de ahora siempre que quiera dirigirse a su agenda OnLine acceda a la siguiente direccion:</span>
		<div class="margin10">
			<a  href="<?= $nameCompany."/"?>"><?php  echo$link?></a>
		</div>
	</div>
</body></html>