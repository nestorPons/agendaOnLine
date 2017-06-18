$(function(){
$('html')
	.on('click',".btnLoad",function(){
		var frm = $(this).parents('form:first');
		if(frm[0].checkValidity())
			$(this).html('<span class="icon-load animate-spin"></span>');
	})
	$("#form").submit( function(e) {
		 e.preventDefault();
		var _validar = function(){
			echo (validar.email.estado+'/'+validar.nombre.estado+'/'+validar.tel.estado+'/'+validar.pass.estado)
			return  validar.email.estado&&validar.nombre.estado&&validar.tel.estado&&validar.pass.estado
		}

		var parametros = {
				"nombre":$('#nombre').val(),
				"email":$('#email').val(),
				"tel":$('#tel').val(),
				"pass1":$('#pass1').val(),
				"pass2":$('#pass2').val(),
				'empresa': $('#empresa').val()
	        };

		if (_validar()){
		    $.ajax({
				data:  parametros,
				type:  'post',
		        url:   '../php/index/usuario/guardar.php',
				dataType: 'json',
		        })
			.done (function(r){
				if (r.success){
					$.Notify({
						type: 'success',
						caption: 'Guardado',
						content: 'Usuario guardado con éxito! \n Revise su correo electronico.',
						icon: 'icon-floppy'
					})
					$("#cancelar").attr("value","Salir");
				}else{
					$.Notify({
						type: 'warning',
						caption: 'Email ocupado',
						content: 'Seleccione otro email.',
						icon: 'icon-cross'
					})
				}
			})
			.fail (function(mns){
				$.Notify({
					type: 'alert',
					caption: 'No se ha podido guardar el usuario',
					content: 'Error conexión',
					icon: 'icon-cross'
				})
			})
			.always(btnLoad.hide)
		}
	});
})

validar.email.callback = function(){ echo('validandoPost')
	var $parent = $('#email').parent()
	if (!$parent.find('.icon-load ').length)
		$parent.append('<span class="icon-load animate-spin iconClass-inside icon-aux"></span>')

	$parent.find('.icon-load').fadeIn('slow');

	$.post(
		'../php/index/usuario/valEmail.php',
		{email:$('#email').val(),empresa:$('#empresa').val()},
		function(r){
			if(r!=0){
				$('#email')
					.removeClass('input-success')
					.addClass('input-error')
					
				$.Notify({
					type: 'alert',
					caption: 'Email',
					content: 'Email ocupado, seleccione otra cuenta de correo',
					icon: 'icon-mail-alt'
				})
											
				$('.icon-load').fadeOut('slow');

				return false;
			}else{
				$('#email')
					.removeClass("input-error")
					.addClass('input-success')
				$('.icon-load').fadeOut('slow');
				return true;
			}
		})
}