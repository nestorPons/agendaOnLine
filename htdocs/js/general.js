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
	 }
 }

 $('#general')
 .on('click','#btnCambiarPass',function(){
     dialog.open('dlgCambiarPass',config.pass,null,function(){
         dialog.open('dlgCambiarPass')
     })
 })