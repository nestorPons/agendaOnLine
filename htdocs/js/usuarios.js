var usuarios = {
	controller : 'usuarios' , 
	id: 0, 
	init : function () {
		usuarios.select('A')
	 },
	eliminar: function (id, nombre,callback) {
		if ($('#usuarios #id').val()!=-1){
			if (confirm ("Deseas eliminar el cliente "+ id +"," + nombre + "?")) {
				var data = {
					id: id ,
					controller: usuarios.controller, 
					action:DEL
				}
				$.ajax({
					type: "POST",
					dataType: "json",
					data: data,
					url:INDEX ,
					beforeSend: function (){
						$("#usuarios #rowUsuarios"+id).fadeTo("slow", 0.30);
					},
				})
				.done(function(){
					usuarios.rows.del()
					notify.alert('El usuario ha sido eliminado con éxito.','Usuario eliminado!!')
				})
				.fail(function(){
					$("#usuarios #rowUsuarios"+id).show("fast");
					notify.error("¡¡No se pudo borrar el registro!!",'Error!');
				})
			}
		}
		
		dialog.close('dlgUsuarios');
	 },
	guardar: function (idUsuario,nombreUsuario,callback){

		var frm = $.serializeForm('frmUsuarios'),
			data = {
				id:idUsuario||-1, 
				nombre: nombreUsuario||frm.nombre,
				email: frm.email||null,
				tel: frm.tel||null,
				obs: frm.obs||null,
				status: $.isEmpty(frm.activa)?0:2,
				admin : $.isEmpty(frm.admin)?0:1,
				color: (frm.sinColor)?null:frm.color, 
				controller: usuarios.controller,
				action: SAVE}

		$.ajax({
			type: "POST",
			dataType: "json",
			data: data,
			url: INDEX ,
		})
		.done(function(rsp){
			var $this  =$('#frmUsuarios'),
				chckEmail =$.isEmpty(frm.email)?'No':'Si',
				chckObs = $.isEmpty(frm.obs)?'No':'Si',
				admin = $.isEmpty(frm.admin)?0:1,
				activa = $.isEmpty(frm.activa)?1:0

				if (data.id == -1 ){ 
					//NUEVO ...
					data.id = rsp.id 
					usuarios.rows.add(data)
					notify.success('Usuario guardado con éxito!.','Nuevo usuario',false, $('#crearCita #cliente'))
					 
				}else{ 

					//EDITANDO....
					$('#rowUsuarios'+data.id)
						.data('color', data.color)
						.find(' td:nth-child(3)')
							.html(data.nombre)
							.data('value',data.nombre)
						.end()
						.find(' td:nth-child(4)').html(frm.tel).end()
						.find(' td:nth-child(5)')
							.html(chckEmail)
							.data('value',frm.email)
						.end()
						.find(' td:nth-child(6)')
							.html(chckObs)
							.data('value',frm.obs)

					if(frm.activa){
						if($('#chckOpUsersDel').is(':checked'))
							$("#rowUsuarios"+frm.id)
								.addClass('mostrar_baja')
								.removeClass('ocultar_baja')
								.fadeTo("slow", 1);
						else
							$("#rowUsuarios"+frm.id)
								.addClass('ocultar_baja')
								.removeClass('mostrar_baja')
								.hide();
						$('#lstClientes [data-name="'+normalize(frm.nombre)+'"]').remove();
					}else{
						$("#rowUsuarios"+frm.id)
							.removeClass('mostrar_baja ocultar_baja')
							.fadeTo("slow", 1)
						$('#lstClientes')
							.append('<option data-name="'+normalize(frm.nombre)+'" value = ' + frm.nombre+  '>'+frm.id+'</option>')
					}	

					notify.success('Usuario guardado con éxito!.','Usuario editado')						
				}

			if (dialog.isOpen == 'dlgUsuarios'){
				dialog.close('dlgUsuarios')
				usuarios.select(frm.nombre[0])
			}
			
			typeof callback == "function" && callback()
			
		})
		.fail(function( jqXHR, textStatus, errorThrown ){
				alert( jqXHR + ' , '  +  textStatus + ' , ' +  errorThrown )
			})
	
	 },
	rows: {
		add : function(data, callback){
			var $template = $('#usuarios').find('.template')
 			
				$template.clone()
						.removeClass('template')
						.attr('id', 'rowUsuarios'+data.id)
						.data('value',data.id)
						.data('color',data.color)
					.find('[name=id]').html(data.id).end()
					.find('[name=nom]')
						.html(data.nombre)
						.attr('id',normalize(data.nombre))
						.end()
					.find('[name=tel]').html(data.tel).end()
					.find('[name=email]')
						.html($.isEmpty(data.email)?'No':'Si')
						.data('value',data.email)
						.end()
					.find('[name=obs]')
						.html($.isEmpty(data.obs)?'No':'Si')
						.data('obs',data.obs)
						.end()
					.find('[name=admin]')
						.html($.isEmpty(data.admin)?'No':'Si')
						.data('value',data.admin)
						.end()
					.insertAfter($template)
						
			$('#lstClientes').append(
				'<option data-id='+data.id+' data-name="'+normalize(data.nombre)+'" value = "' + data.nombre + '">'+data.id+'</option>')	
		},
		del : function(){
			$("#usuarios #rowUsuarios"+id).addClass('ocultar_baja').fadeTo('fast',1)
			$('#lstClientes [data-id="'+normalize(nombre)+'"]').remove()
		}
	 },
	dialog: function (id){
		usuarios.id = id 
		var _fnLoad = function (r) {
			$('#dlgUsuarios').find('#id').val(id)
					
				if (id!=-1){
					var $this = $("#usuarios #rowUsuarios"+id)
					
					var nom = $this.find("[name='nom']").text()
					var email = $this.find("[name='email']").data("value")
					var tel = $this.find("[name='tel']").text()
					var obs = $this.find("[name='obs']").data("value")
					var admin = $this.find("[name='admin']").data("value")
					var baja = ($this.hasClass('mostrar_baja')||$this.data('status')!=0)
					var color = $this.data('color')
					var sinColor = $this.data('color')?false:true

					$("#dlgUsuarios")
						.find('#nombre').val(nom).end()
						.find('#email').val(email).end()
						.find("#tel").val(tel).end()
						.find("#obs").val(obs).end()
						.find("#admin").attr('checked', admin!=0).end()
						.find("#activa").attr('checked', baja).end()
						.find('#eliminar').val('Eliminar').end()
						.find('#color').val(color).end()
						.find('#sinColor').prop('checked', sinColor)
				}else{
					$("#dlgUsuarios")
						.find("#nombre").val($('#buscarTxt').val()).end()
						.find("#activa").attr('checked', false).end()
						.find("#admin").attr('checked', false).end()
						.find('#eliminar').val('Cancelar')
				}
		 } , 
		_fnDel = function (r) { 
			usuarios.eliminar($('#dlgUsuarios #id').val(),$('#dlgUsuarios #nombre').val())
		 }

		dialog.open('dlgUsuarios',function(){usuarios.guardar(usuarios.id)},_fnDel,_fnLoad)

	 },
	historial: function (id){
		var $template = $('#dlgHistorial')
		var data = {
			controller : 'dialogs',
			view : 'dlgHistorial', 
			id:id
		}
		//Si esta el contenedor
		if($template.length){
echo(2)
			$.post(INDEX,data,function(data){
				dialog.create('dlgHistorial',null, null, function(){
					$('#contenedorHistorial').empty();
					for (let i = 0; i<data.length;i++){
					
					$('#dlgHistorial .plantilla')
						.clone(true,true)
						.removeClass('plantilla')
						.data('fecha',data[i].Fecha)
						.find('.hisAgenda').html(data[i].Agenda).end()
						.find('.hisIdCita').html(data[i].IdCita).end()
						.find('.hisFecha').html(Fecha.print(data[i].Fecha)).end()
						.find('.hisHoras').html(data[i].Hora).end()
						.find('.hisSer').html(data[i].Codigo).end()
						.appendTo('#dlgHistorial .tablas')
					}
				},JSON)
			})
		} else { 
echo(1)
			$.post(INDEX,data,function(html){
				$('#dialogs').append(html)
				dialog.open('dlgHistorial')
			},'html')			
		}
	 },
	select: function (letra) {
	//Coloreal filas de las tablas
		var $sec = $('#usuarios')
		$sec 
			.find('a.c3').removeClass('c3').end()
			.find('#menu'+letra).addClass('c3').end()
			.find('tbody tr:visible').hide().end()
			.find('.name[id^="'+letra.toLowerCase()+'"]').parent().show()
		colorear_filas($sec.find('.colorear-filas'))
	},
	validate : {
		form : function(){
			var value = $('#dlgUsuarios	#nombre').val()

			if ($.isEmpty(value)){
				
				notify.error('El campo nombre no puede estar vacio.','Error crear usuario') 
				return false

			}else{

				return usuarios.validate.name(value)
				
			}
		 },
		name : function (name) {
			var idName = $('#dlgUsuarios #id').val() ;
			var obj = $('#usuarios #' +  normalize(name) ) ;

			if($('#usuarios #' +  normalize(name) ).length == 0){
				return true ;
			}else{
				if (obj.parents('tr').attr('id') != 'rowUsuarios'+idName){
					notify.error('El nombre esta en uso.','Error crear usuario')  ;
					return false ;
				}else{
					return true ;
				}
			}
		 },	
		

	 }
 }
$("#usuarios")
	.on('click','[name*="editar"]',function(){

		var id = $(this).parents('tr:first').data('value')
		usuarios.dialog(id)
	})
	.on('click',"[name='historia']",function(e){
		usuarios.historial($(this).parents('tr').data('value'))
	})
	.on('click','#mainLstABC a',function(){
		usuarios.select($(this).html());
	})
	.on('change','#lstABC',function(){usuarios.select($(this).val())})


usuarios.init()
