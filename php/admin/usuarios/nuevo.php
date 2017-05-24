<!DOCTYPE html>
<html lang="es">	
<head>
<title>Nuevo usuario</title>
<?php 
include "../../../../libs/head.php";
?>
</head>
<body>
	<script>
function guardarUsuario(){
	var formulario = $("#form").serializeArray();
	console.log (formulario);
	$.ajax({
		type: "POST",
		data: formulario,
		url: "guardar.php",
		dataType: "json",
	})
	.done(function(rsp){
		window.location.href='../../lista.php';
	})
	.fail(function(rsp){
		$("#error").fadeIn(1000);
		console.log (rsp);	
	});
};
</script>
    <div class="login">	
		<h1>Registro nuevo usuario</h1>
		<div name="error" id= "error" class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Error!</strong> Nombre o email ocupados.
		</div>

		<form id="form">
			<input type="text"     			 
				name="nombre"   
				id="nombre"
				placeholder="Introduzca nombre">
				</br>
			<input type="text" 
				name="apellidos"
				id="apellidos" 
				placeholder="Introduzca apellidos">
				</br>
			<input type="Email"
				name="email"
				id="email"
				placeholder="Introduzca email">
				</br>
			<input type="text"
				name="tel"
				id="tel"
				placeholder="Telefono de contacto" > 	
			 <p>
				<input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="window.location.href='../../lista.php'">
				<input type="button" name="guardar" id="guardar" value="Guardar" onclick="guardarUsuario()">
			 </p>
      </form>
    </div>

</body>
</html>
