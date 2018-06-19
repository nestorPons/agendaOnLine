<form id="usuarioFrm" >	
	<h1 class="heading margin0">Editar usuario</h1>
	<input type="hidden" id="idUsuario" value="<?=$User->id?>">
	<div class="iconClass-container icon-left">
		<input type="text" id="nombre"  value="<?=$User->nombre?>" placeholder="Introduzca nombre y apellidos" required>
		<i class="iconClass-inside icon-user-1"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="email" id="email"   value="<?=$User->email?>"  placeholder="Introduzca email" email>	
		<i class="iconClass-inside icon-mail"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="tel" id="tel" value="<?=$User->tel?>"	placeholder="Telefono de contacto" >
		<i class="iconClass-inside icon-phone"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="password" id="opass" placeholder="Contraseña actual" autocomplete="off">
		<i class="iconClass-inside icon-eye"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="password" id="npass" placeholder="Cambiar contraseña" autocomplete="off">
		<i class="iconClass-inside icon-eye"></i>
	</div>
	<div class="iconClass-container icon-left">
		<input type="password" id="rpass" placeholder="Repita la contraseña" autocomplete="off" >
		<i class="iconClass-inside icon-eye"></i>
	</div>
	<p>
		<button type="submit" class="btn-success btnLoad" id="btnGuardarCita" data-value="Guardar">Guardar</button>
		<input type="button" class="btn-danger cancelar" name="cancelar" value="Cancelar"> 
	</p>
</form>

