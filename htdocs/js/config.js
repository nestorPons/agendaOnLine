'strict'
main.scripts.loaded.push('config')
config ={
	isLoad :true,
	change : false,
	controller : 'config' ,
	init : function(){
		$('#config')
		.on('change','input',function(){
			config.change = true;
		})
	}, 
	set: {
		nameAgenda : function(id, name){
			$('#nameAgendaConfig' + id).val(name);
		}
	 }, 
	pass: 	function (){ 
		var $frm = $('#dlgCambiarPass'),
			newPass = $frm.find('#pass').val(),
			repeatPass = $frm.find('#repeatPass').val(),
			oldPass =  $frm.find('#oldPass').val()

		if(repeatPass==newPass && !$.isEmpty(oldPass)){
			var data = {
				oldPass : Tools.SHA(oldPass),
				newPass: Tools.SHA(newPass) ,
				controller: config.controller, 
				action: SAVE
				}
			$.post(INDEX,data,function(r){
				if(r.success){
					notify.success('Contraseña cambiada' , 'Guardada') 
					dialog.reset()
					dialog.close('dlgCambiarPass')				
				}else{
					notify.error( r.err ) 
					btn.load.hide()
				}
			},'json')
			.fail(function( jqXHR, textStatus, errorThrown ){
				alert( jqXHR + ' , '  +  textStatus + ' , ' +  errorThrown )
			})
		}else{
			btn.load.status=false;
			notify.error('Algun dato no esta correcto, /n verifique el formulario.') ;
		}
		},
	guardar: function (callback){

		var data = new FormData($("#config form")[0]) 

		data.append("controller", config.controller )
		data.append("action", true )
		$.ajax({
			url: INDEX,
			type: "POST",
			data: data,
			contentType: false,
			processData: false
		})
		.done(function(r){
			if (r.success){
				notify.success('Guardado con éxito.')
				let n = ($('#showInactivas').is(":checked"))?1:0
				admin.inactivas.change(n)
				
				$("#config #respuestaLogo").html("<img src="+r+"/logo.png></img>") 
			} else {	
				notify.error('No se ha podido guardar los datos')	
			}
		})
		.fail(function( jqXHR, textStatus, errorThrown ){
			alert( jqXHR + ' , '  +  textStatus + ' , ' +  errorThrown )
	 		typeof callback == "function" && callback()
		})
		.complete(_=>{
			console.log('COMPLETE')
			typeof callback == "function" && callback()
		})

		config.change = false
		},

  }
