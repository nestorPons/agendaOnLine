main.scripts.loaded.push('usuarios');

var usuarios = {
	isLoad : true, 
	controller : 'usuarios' , 
	id: 0, 
	init : function () {
		let $this = this	
		$this.select('A')
		$("#usuarios")
			.on('click','.row_usuario',function(e){
				const id = $(this).data('value')
				$this.dialog(id)
			})
			.on('click',"[name='historia']",function(e){
				e.stopPropagation()
				$this.id = $(this).parents('tr').data('value')
				$this.historial($this.id)
			})
			.on('click','#mainLstABC a',function(){
				$this.select($(this).html());
			})
			.on('change','#lstABC',function(){$this.select($(this).val())})
			
		$('#dialogs')
			.on('change','#ultimosServicios',function(){
				$this.historial($this.id,$(this).val())
			})
			.on('click','.fnBuscarCita', function(){
			})
	 },
	guardar: function (idUsuario =-1 ,data=null,callback){
		if(data == null){
			var frm = new Object
			frm = $.serializeForm('frmUsuarios'),
				data = {
					nombre: frm.nombre,
					email: frm.email||null,
					tel: frm.tel||null,
					obs: frm.obs||null,
					status: $.isEmpty(frm.activa)?0:2,
					admin : $.isEmpty(frm.admin)?0:1,
					color: (frm.sinColor)?null:frm.color}
		 }
				
		data.controller = usuarios.controller
		data.action = SAVE
		data.id = idUsuario
		
		$.ajax({
			type: "POST",
			dataType: "json",
			data: data,
			url: INDEX ,
		})
		.done(function(rsp){

			if(data.dateBaja == undefined){

				if (data.id == -1 ){ 
					//NUEVO ...
					data.id = rsp.id 
					usuarios.rows.create(data)
					notify.success('Usuario guardado con éxito!.','Nuevo usuario',false, $('#crearCita #cliente'))

				}else{ 
					//EDITANDO	....
					usuarios.rows.edit(data)
					notify.success('Usuario guardado con éxito!.','Usuario editado')						
	
				}

			}
			if (dialog.isOpen == 'dlgUsuarios'){
				dialog.close('dlgUsuarios')
				usuarios.select(frm.nombre[0])
			}
			typeof callback == "function" && callback()
			
		})
		.fail(function( jqXHR, textStatus, errorThrown ){
				alert( jqXHR + ' , '  +  textStatus + ' , ' +  errorThrown )
				notify.error('No se pudo guardar el usuario')
		 })
	
	 },
	rows: {
		create : function(data){
			let $template = $('#usuarios').find('.template')
 			
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
									// Guardar en datalist 
			$('#lstClientes').append(
				'<option data-id="'+data.id+'" data-name="'+normalize(data.nombre)+'" value="'+data.nombre+'" data-color="#'+data.color+'"></option>'
			)			
		
		},
		edit : function(data){
			const chckObs = $.isEmpty(data.obs)?'No':'Si'

			$('#rowUsuarios'+data.id)
				.data('color', data.color)
				.find('td[name="nom"]')
					.html(data.nombre)
					.data('value',data.nombre)
				.end()
				.find('td[name="tel"]').html(data.tel).end()
				.find('td[name="email"]')
					.html(data.email)
					.data('value',data.email)
				.end()
				.find('td[name="obs"]')
					.html(chckObs)
					.data('value',data.obs)
			
			// Editar el datalist 
			$('#lstClientes')
				.find('option[data-id="'+data.id+'"]')
					.attr('data-name',normalize(data.nombre))
					.attr('data-color',data.color)
					.val(data.nombre)
			//Editar los lbl
			$('.lbl').each(function(){
				let $name = $(this).find('div.nombre'),
					idUserLbl = $name.attr('id');

				if(idUserLbl == data.id ) {
					$name.find('span').text(data.nombre)
				}
			})
		},
		delete: function (data) {
			let id = data.id , 
				nombre = data.nombre 
				
			if ($('#usuarios #id').val()!=-1){
				if (confirm ("Deseas eliminar el cliente "+ id +"," + nombre + "?")) {
					data = {
						dateBaja: Fecha.general, 
						status: 2,
						nombre : nombre
					}
					usuarios.guardar(id,data,function(){
						$('#rowUsuarios'+id).hide('explode').remove()
					})
				}
			}
			
			dialog.close('dlgUsuarios');
		 },
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
			let data = {
				id : $('#dlgUsuarios #id').val(),
				nombre : $('#dlgUsuarios #nombre').val()
			}
			usuarios.rows.delete(data)
		 }

		dialog.open('dlgUsuarios',function(){usuarios.guardar(usuarios.id)},_fnDel,_fnLoad)

	 },
	historial: function (id,limit=10){
		var data = {
			controller : 'usuarios',
			action : 'historial', 
			id:id, 
			limit : limit
		 }
		
		$.post(INDEX,data,function(datos){	

			dialog.open('dlgHistorial',null, null, function(){
				var $this=$('#dlgHistorial'), 
					d = datos.data , 
					len = d.length

				$this.find('tbody td').remove()			

				for (let i = 0; i<len ;i++){
					let servicios = d[i].servicios 
					

						$this
							.find('#hisCita')
							.clone(true,true)						
							.removeClass('template')
							.removeAttr('id')
							.find('.hisAgenda').html(d[i].agenda).end()
							.find('.hisIdCita').html(d[i].id).end()
							.find('.hisFecha').html(Fecha.print(d[i].fecha)).end()
							.find('.hisHoras').html(d[i].hora).end()
							.appendTo($this.find('table'))
					
					servicios.forEach(e => {
						let $clone = 
						$this
							.find('#hisServicios')
							.clone(true,true)
							.removeClass('template')
							.removeAttr('id')
						$clone
							.find('.hisServicio')
								.text(e)
						$clone.appendTo($this.find('table'))
					})		
				}
			},'json')
		})
	 },
	select: function (letra) {
	//Coloreal filas de las tablas
		const $sec = $('#usuarios')
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
		 }	
	 }
 }
