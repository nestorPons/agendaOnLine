'strict'
var general = {
	guardar: function (callback){

		if (general.validar()){
			var  data = $('#general form').serializeArray()
			data.push({name : 'controller' , value : 'general'})
			data.push({name : 'action' , value : SAVE})

			$.post(INDEX, data , function(r) {
				if (r.success){
					notify.success( 'Configuración guardada') 
					typeof callback == "function" && callback()
				} else {
					_err(r.err)
				}		
			},'json')
			.fail(function(r){console.log(r)})
		} else _err()

		function _err(input){
			notify.error( 'No se pudo guardar los datos.<br> Compruebe todos los campos')
			if(input) $('#general form').find('[name='+input+']').addClass('input-error')
			typeof callback == "function" && callback()
		 }
	 },
	validar: function () {
		//AKI :: implementar validacion de formularios !!important
		var r = true
		$('#generalFrm input').each(function(){
			let val = $(this).val() 
			if (val=='') r = false
		})
		
		return r
	 }, 
	 pass: function(pass,rpass,opass){
	 var
	  	$dlg =  $('#dlgCambiarPass'),
		$pass = $dlg.find('#pass'),
		pass = $pass.val(), 
		$rpass = $dlg.find('#repeatPass'), 
		rpass = $rpass.val(), 
		$oldPass = $dlg.find('#oldPass'), 
		opass = $oldPass.val()		

		 data ={
			controller: 'password', 
			action : EDIT, 
			pass: Tools.SHA(pass), 
			oldPass: Tools.SHA(opass)
		 }
		 if(pass!=undefined && pass===rpass){
			$.post(INDEX, data,
				function (r, textStatus, jqXHR) {
					if(r.success){
						notify.success('Password cambiado con exito')
						dialog.close()
					} else {
						$oldPass.removeClass().addClass('input-error')
						notify.error('Error en passwords!!')
					}
					btn.load.hide()
				},
				'json'
			)
		 }else {
			$pass.removeClass().addClass('input-error')
			$rpass.removeClass().addClass('input-error')
			btn.load.hide()
		 }
	 }
 }

$('#general')
 .on('click','#btnCambiarPass',function(){

	 	dialog.open('dlgCambiarPass',general.pass)
 })