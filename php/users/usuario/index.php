<form id="usuarioFrm" >	
	<?php 
	$sql = "SELECT Nombre, Email, Tel FROM usuarios WHERE Id = " . $_SESSION['id_usuario'];
	if($result= mysqli_query($conexion,$sql)){
		if ($row = mysqli_fetch_row($result)){
			$nombre = $row[0];
			$email = $row[1];
			$tel = $row[2];
		}
	}	
	?>
	<h1 class="heading margin0">Editar usuario</h1>
	<input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION['id_usuario']?>">
	<div class="iconClass-container icon-left">
		<input type="text"  name="nombre" id="nombre"  value="<?php echo $nombre?>" placeholder="Introduzca nombre y apellidos" required>
		<i class="iconClass-inside icon-user-1"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="email"  name="email" id="email"   value="<?php echo $email?>"  placeholder="Introduzca email" email>	
		<i class="iconClass-inside icon-mail"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="tel" name="tel" id="tel" value="<?php echo $tel?>"	placeholder="Telefono de contacto" >
		<i class="iconClass-inside icon-phone"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="password" name="oldPassFake" id="oldPassFake"   placeholder="Contraseña actual" autocomplete="off">
		<input type="hidden" name="oldPass" id="oldPass"   placeholder="Contraseña actual" autocomplete="off">
		<i class="iconClass-inside icon-eye"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="password" name="passFake" id="passFake"   placeholder="Cambiar contraseña" autocomplete="off">
		<input type="hidden" name="pass" id="pass"   placeholder="Cambiar contraseña" autocomplete="off">
		<i class="iconClass-inside icon-eye"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="password" name="rpassFake" id="rpassFake" placeholder="Repita la contraseña" autocomplete="off" >
		<input type="hidden" name="rpass" id="rpass" placeholder="Repita la contraseña" autocomplete="off" >
		<i class="iconClass-inside icon-eye"></i>
	</div>
	<p>
		<input type="button" class="btn-danger cerrar" name="cancelar" value="Cancelar"> 
		<button type="submit" class="btn-success btnLoad" id="btnGuardarCita" data-value="Guardar">Guardar</button>
	</p>
</form>

