main.scripts.loaded.push('users');
var servicios = { 
	mostrar: function(id_familia, no_validate) {
		var id = id_familia, no_validate = no_validate || false
		
		if (no_validate && $('#servicios .fam'+ id).is(':visible') || $('#crearCita .fam'+ id).is(':visible')  ) return false ;

		var id = $.isEmpty(id)?0:id; 

		$('.contenedorServicios').each(function(){
			var $this = $(this)
			$this.find('tbody tr').hide(function() {
				$this.find('.fam'+id).show()		
			})
		})

		$('.menuServicios').each(function(){
			$(this)
				.find('.c3').removeClass('c3').end()
				.find('#'+id).addClass('c3');
		})
	},
 }
var crearCita ={
	data : new Object(), 
	init : function(){
		var clase = $('#crearCita .contenedorServicios tbody tr').attr('class') ; 

		if (!$.isEmpty(clase)){
			var clase_id = clase.replace(/\D/g,'');
			servicios.mostrar(clase_id) ;
		}
		cargarDatepicker()
	 },
	set : {
		nameAgenda :function(id,name){
			$('#crearCita #lblagenda'+id).text(name)
		 }
	 }, 
	servicios: {
		buscar : function(val){
			var $sec = $('#crearCita'), 
				$conSer = $sec.find('.contenedorServicios')

			if($sec.is(':visible')){
				$conSer
				.find('tr').hide()
				.find('.descripcion:contains("'+val+'")').parents('tr').show()
			}
		}
	 },
	idUser : function () {
		return $('main').attr('iduser');
	 }, 
	cliente: function (){
		//guardo cliente mediante formulario creafrCita
		var $cliente = $('#crearCita #cliente'),
			data = {
				nombre: $cliente.val()
			}

		usuarios.guardar(-1,data)	
		dialog.close()
	 },
	dialog: function (){
		var self = crearCita , sec =  $('#crearCita') , 
		idSer = new Array() ,
		strServ ="" 
		
		sec.find('[name="servicios[]"]:checked').each(function(){
			strServ += $(this).attr('id') + ", "
			idSer.push($(this).val())
		})
		var _load = function(){
			strServ = strServ.slice(0,-2)		
			data = {
				fecha : Fecha.general , 
				hora : sec.find('.horas:checked').val(), 
				agenda : crearCita.data.agenda,
				servicios : idSer ,
				nota : sec.find('#crearCitaNota').val(),
				tiempo_servicios : parseInt(sec.find('#tSer').text()) 
			}
			$.extend(crearCita.data, data)

			$('#dlgGuardar')
				.find('#lblhora').html(data.hora).end()
				.find('#lblfecha').html(Fecha.print()).end()
				.find('#lblCliente').html(data.nombre).end()
				.find('#lblSer').html(strServ)
				
		}
		dialog.open('dlgGuardar',self.guardar, dialog.close,_load)
	 },
	guardar: function(){
		var self = crearCita 
		self.data.controller = 'cita'
		self.data.action = 'save'

		if(self.validate.form()){
			$.post(INDEX,crearCita.data,function( rsp ){
				if(rsp.success){
					if(rsp.ocupado){
						notify.error( rsp.mns.body , rsp.mns.tile )
					}else{	

						self.data.idCita = rsp.idCita
						self.data.idUsuario = rsp.idUser
						self.data.servicios = rsp.services

						//Cambiar en solo en usuarios
						historial.request()
						// Solicitar permiso para mandar notificaciones 
						if (("Notification" in window)) {
							if (Notification.permission === 'default'){
								notify.info(
									'Acepte la siguiente solicitud,<br/> si desea recibir notificaciones para recordarle sus citas<br/> Gracias.', 
									'SOLICITUD', 
									3000, 
									Notification.requestPermission

								)
							}		
						}
						
    					menu.cerrar()	
					}
				} else {
					echo(rsp)
					notify.error('Error inesperado')
				}
				dialog.close('dlgGuardar')
			},'json')
			.fail(function( jqXHR, textStatus, errorThrown){
				notify.error(jqXHR + '<br/>' +  textStatus + '<br/>' + errorThrown);
				return false;
			})
		}else{
			notify.error('Complete todos los datos')
			return false
		}

	 },
	load: function(){
		$('#btnSearch').hide()
		if(crearCita.data.agenda){
			$sec = $('#crearCita')
			$sec.find('#agenda'+crearCita.data.agenda).prop('checked', true)
		 }
	 }, 
	horas: {
		iniciar: function(){	

			if (!$('#crearCita #tablas table').length) cargarDatepicker();

			for(let i = 0 ; i <= config.margenDias ; i++){
	
				var date = Fecha.calcular(i ,  Fecha.id )
				crearCita.horas.crear(Fecha.number(date))
			}
			
		 },
		hide: function(){
			$('#crearCita').find('#tablas').hide()
		}, 
		show: function(){
			$('#crearCita').find('#tablas').show()
		}, 
		load : function () {

			var tiempoServicios = 0, 
				lblTS = $('#tSer'), 
				$sec = $('#crearCita'), 
				serviciosSeleccionados = $sec.find('.idServicios:checked')

				serviciosSeleccionados.each(function(){
					tiempoServicios += $(this).data('time')
				})

			lblTS.text(tiempoServicios)
			crearCita.horas.pintar(Fecha.id,tiempoServicios)
	
		 } ,
		crear: function (id_table){
			var data = {
				agenda: crearCita.data.agenda,
				fecha:id_table , 
				controller : 'crearCita.horas'}

			if ($('#crearCita #'+id_table).length) $('#crearCita #'+id_table).remove()
			this.hide()
			let that = this
			$.post(INDEX , data , function(html){
				var m = document.getElementById('tablas')
				m.innerHTML = html	
				crearCita.horas.load()
				that.show()
			})

		 },		
		pintar: function(id_table, tiempoServicios = 0){

			var self = crearCita, 	
				$sec = $('#crearCita'),  
				ts = parseInt(Math.ceil(tiempoServicios/15)),
				$dia = $sec.find('#'+ id_table), 
				$horas = $dia.find('.horas'), 
				count = ts-1 

			$dia.removeClass('reservado').find('input').attr('disabled',false)
	
			for (let i = $horas.length - 1  ; i >= 0 ; i--){
				let $this = $dia.find('#hora'+i)
				if ( $this.hasClass('ocupado')) count = ts 

      			if ( count > 0 ) $this.attr('disabled',true).parent('label').addClass('reservado')  
				count-- 		
			}
		 },
		sincronizar: function(){
			crearCita.horas.crear(Fecha.id)	
		 },
	 },
	reset: function(){
		$('.steperCapa li').hide(function(){
			$('#step0').show()
		})

		$('#crearCita')
			.find('.dialog').hide().end()
			.find('.steperCapa').hide().end()
			.find('#stepper0').show().end()
			.find('input[name="servicios[]"]:checked')
				.each(function() {
					$(this).prop('checked',false)
				})
			.end()
			.find('input[name="hora[]"]:checked').prop('checked',false).end()
			.find('#nombre')
				.removeClass('input-success')
				.removeClass('input-error')
			.end()
			.find('#cliente')
				.val("")
				.removeClass('input-error')
			.end()
			.find('#crearCitaNota').val("").end()
			.find('[name="agenda[]"]').attr('checked',false)
			.first().prop('checked',true)

		$('#dlgGuardar')
			.find('#lblSer').empty().end()
			.find('#lblHora').empty().end()
			.find('#lblFecha').empty().end()
			.find('#lblSer').empty().end()
			.find('#lblCliente').empty()

		crearCita.data.hora = '';
		crearCita.data.agenda = 0 
		dialog.close('dlgGuardar');
	 },
	stepper: function(index){
		var $visible = $('.steperCapa:visible')
		var $stepper = $('#stepper'+index)
		if($visible.attr('id')==$stepper.attr('id'))return false
		if (!$stepper.is(':visible')&&$visible.length){
			if(index==0){
				_slider()
				
			}else if(index==1 &&crearCita.validate.name()){
				$('#btnSearch').show()
				crearCita.data.agenda = $('#crearCita').find('input[name="agenda[]"]:checked').val()
				crearCita.data.nombre =  $('#crearCita #cliente').val() 
				//Solo en usuarios
				crearCita.data.idUser = crearCita.idUser()
				$('.tblHoras').show()
					
				_slider(servicios.init) 

			} else if(index==2&&crearCita.validate.service()){
				$('#btnSearch').hide()
				if(crearCita.validate.name())_slider(function(){

				});
			}
		 }
		function _slider(callback){
			var dir = $visible.data('value')>0||1
			var dirEntrada = index-dir<0?'right':'left'
			var dirSalida = dirEntrada=='right'?'left':'right'

			$('.stepper') //esto es para colorear el stepper activo
				.find('li').removeClass('current').end()
				.find('#step'+index).addClass('current');
			$('#crearCita').find('.steperCapa').hide()
			$visible.hide("slide", { direction: dirSalida }, 750,function(){
				$stepper
					.removeClass('hidden')
					.show("slide", { direction: dirEntrada }, 750, function(){$('.tile-active').height('auto')})
			 })
			typeof callback == "function" && callback()
		 }
	 },
	validate : {
		form : function (){
			return $('#crearCita [name="servicios[]"]:checked').length!==0
				&&$('#crearCita #cliente').val()!==""
				&&$('#crearCita [name="hora[]"]:checked').length!==0;
		 },
		name : function () {
			return true;
		 }, 
		service: function(){
			crearCita.horas.sincronizar();
			$('#crearCita #lblSer').empty();
			var $ser = $('#crearCita [name="servicios[]"]:checked');
			if($ser.length==0){
				$('#login #crearCita [name="stepperServicios"]').popover('show');
				return false;
			}else{
				$ser.each(function(i,v){
					var txtSer= $(this).attr('id');
					$('#crearCita #lblSer').append(txtSer+', ');
				})
				return true;
			}
		 }
	 },
 }
var historial = { 
	actualizar:function(){
		console.log('Actualizando historial ...')
		let num = $('section#historial div.cita').length
		$('#lblHis').html(num)
		// Abrimos base de datos
		var request = indexedDB.open('citas',1);
		request.onsuccess = event => {

			var db = event.target.result, 
				store = db.transaction('cita', "readwrite").objectStore("cita")

				//Bucle recorrer las citas del historial y se añaden a idb
				$('.cita').each(function(){
					let fecha = $(this).data('fecha'), 
						hora = $(this).data('hora'), 
						agenda = $(this).data('agenda'),
						id = fecha.replace(/[-]/gi, '') + hora.replace(/[\:]/gi, '') + agenda,
						s = store.get(id)
						s.onsuccess = e => {
							
							e = e.target.result
							if(e == undefined){
								// No existe el registro lo crea
								let sa = store.add({
									id : id,
									fecha : fecha, 
									hora : hora, 
									agenda : agenda, 
									notificacion : 0 
								})
								sa.onsuccess = e => console.log( 'guardado : ' + e.target.result)
								sa.onerror = e=> console.log(' error : ' + e)
							}
						}
						s.onerror = e=> console.log(' error get : ' + e.target)

				})

				// Se recorre la idb para eliminar los registros obsoletos

				store.openCursor().onsuccess = function(event) {
					var cursor = event.target.result;
					if(cursor) {
						let now = new Date, 
							myDate = new Date(cursor.value.fecha + ' ' + cursor.value.hora)
						if(now >= myDate) cursor.delete()

						cursor.continue();
					}
				};
				db.close();
				$.post(INDEX, {controller : 'service-worker', action: 'refresh'} ,'json')
			
		}
		request.onerror = function(event) {
		// Manejar errores.
		};
		request.onupgradeneeded = function(event) {

			var db = event.target.result;

			// Se crea un almacén para contener la información de nuestros cliente
			// Se usará "ssn" como clave ya que es garantizado que es única
			var objectStore = db.createObjectStore("cita", { keyPath: "id" });

			// Se usa transaction.oncomplete para asegurarse que la creación del almacén 
			// haya finalizado antes de añadir los datos en el.
			objectStore.transaction.oncomplete = function(event) {

			}
		};
	 },
	request: function(){
		var data = {
			controller : 'users', 
			action: 'view', 
			section: 'historial'
		 }
		$.post(INDEX, data,function (html, textStatus, jqXHR) {
			$('#historial').find('#lineasHistorial').html(html).promise().done(historial.actualizar)
		},'html')
	 }, 
	del: function(id){
		$('.cita[idCita="'+id+'"]').hide('explode').remove().promise().done(historial.actualizar)
	 }
 }
var cita = {
	del : function (id, fecha, hora, agenda) {
		var data = {
			controller: 'cita', 
			action: DEL, 
			id: id, 
			// Necesarios para el indice de idb
			fecha : fecha, 
			hora: hora, 
			agenda: agenda
		}
		
		$.post(INDEX, data,function (r, textStatus, jqXHR) {
			//AKI:: Eliminar la cita del service worker
			if(r.success) historial.del(id)
		},'json')
		
	 },
	add : function () {
	 }
 }
var users = {
	data: new Object,
	last:  new Object,
	init : function(){
		console.log('Zone user init...')
		cargarDatepicker()
		crearCita.init()
		historial.actualizar()
		$('tytle').text('Menu agenda On line zona usuarios')
		$('#navbar')
			.on('click','#btnConfig, #btnDatos',function(){
				menu.toggle($(this))
			})
			.on('click','#goHome',menu.cerrar)

		$('input:password').blur(function(){
			var pass1 = $('#pass').val()		
			var pass2 = $('#rpass').val()
			validar.pass(pass1,pass2)

		})

		$('.nextSteeper').click(function(){
			var val = $('.steperCapa:visible').data('value')
			crearCita.stepper(val+1)
		})

		$('#crearCita')
			.on('click','a',function(){servicios.mostrar($(this).attr('id'))})
			.on('change','#lstSerSelect',function(){servicios.mostrar($(this).val())})
			.on('click','.siguiente',function(e){crearCita.stepper($('div [id^="stepper"]:visible').data('value') + 1)})	
			.on('click','.horas',crearCita.dialog)
			.on('click','.idServicios',function(){crearCita.horas.load($(this))})
			.on('click','[name="agenda[]"]',function(){
				crearCita.data.agenda = $(this).val()
				})
			.on('change','#crearCitaNota',function(){
				crearCita.data.nota = $(this).val() 
				})
			.find('#tablas')
				.on("swipeleft",function(){sincronizar(null,1)})
				.on("swiperight",function(){sincronizar(null,-1)})
			.end()
				.on('click','#btnCancelarDlg',function(){closeDialog('#crearCita #dlgCliente')})
			
		$('#historial')
			.on('click','.fnDel',function(){
				cita.del($(this).parent().attr('idSer'))
			})

		$('#usuarioFrm')
			.on('submit',function(e){users.guardar(e,$(this))})
			.on('blur','#oldPassFake',function(){
				$('#oldPass').val(Tools.SHA($(this).val()))
				users.comprobarContraseña($('#oldPass'));
				})
			.on('change','#oldPassFake',function(){
				$(this).removeClass('input-error input-success');
				})
			.on('blur','#passFake',function(){
				$('#pass').val(Tools.SHA($(this).val()))
				})
			.on('blur','#rpassFake',function(){
				$('#rpass').val(Tools.SHA($(this).val()))
				})

	
	 },
	guardar_array: function(){
		this.last = this.data

		this.data = {
			nombre:$('#nombre').val() ,
			email:$('#email').val(),
			tel:$('#tel').val(),
			authEmail : $('#authEmail').find('input:checkbox').prop('checked')?1:0, 
			controller : 'users' , 
			action : SAVE
         }
	 }, 
	hay_cambios: function(){
		return (
			this.data.nombre != $('#nombre').val() ||
			this.data.email != $('#email').val() ||
			this.data.tel != $('#tel').val() ||
			this.data.authEmail != $('#authEmail').find('input:checkbox').prop('checked')?1:0 
		)
	 }, 
	revertir_cambios: function(){
		$('#nombre').val(this.last.nombre)
		$('#email').val(this.last.email)
		$('#tel').val(this.last.tel )
		$('#authEmail').is('checked',this.last.authEmail)
	 }, 
	guardar: function($this){
		users.guardar_array()
		var opass = $('#opass').val(),
			npass = $('#npass').val(),
			rpass = $('#rpass').val()
		
		if(!$.isEmpty(opass)) {
			if(users.validar.pass(opass, npass, rpass)){
				notify.error('Al cambiar la contraseña' , 'ERROR CONTRASEÑA')	
				return false 
			} else {
				this.data.opass = Tools.SHA(opass)  
				this.data.npass = Tools.SHA(npass) 
			}
		 }
		$.ajax({
			type: "POST",
			data: this.data,
			url: INDEX,
			dataType: 'json',
		 })
		.done(function(r){
			if(r.success){
				$('#lblNombre').html($('#nombre').val())
				notify.success('Sus datos han sido guardados','Guardado')

			}else{
				notify.error('No se han podido guardar los datos')
				users.revertir_cambios()
			}
		 })	
		.fail(function(r){
			notify.error('No se han podido guardar los datos')
			users.revertir_cambios()
		})
	 },
	validar : {
		pass :function (oPass , nPass , rPass){
			r = $.isEmpty(nPass) 
			r = r ? $.isEmpty(rPass) :  false ;
			r = r ? nPass == rPass :  false ;
			return r
		 }
	 },
	comprobarContraseña: function($this){
		var url = urlPhp +"usuario/validar.php";
		var data = {a:$this.val()};
		$.post(url,data,function(r){
			if(r=="false"){
				$this.parent().find('[id*=Fake]')
					.addClass('input-error') 
				return false;
			}else{
				$this.parent().find('[id*=Fake]')
					.addClass('input-success') 
				return true;
			}
					
		})
	 },
 },
tile = { 
	isOpen : null, 
	active : function(){
		
	}, 
	open : function($this){

		if (this.isOpen != null && this.isOpen.attr('id') === $this.attr('id')) return;
		if (this.isOpen != null ) this.close(); 
		
		this.isOpen = $this; 

		$this
			.addClass('tile-active')
			.prependTo('#contenedorMenuPrincipal')
			.find('.mensaje').hide(500).end()
			.find('.contenido ')
				.show(500)
				.css({'cursor':'initial'})
		
	}, 
	close : function(){
		let t = tile.isOpen
	
		t.removeClass('tile-active')
			.removeAttr('style')
			.find('.mensaje').removeAttr('style').end()
			.find('.contenido ').removeAttr('style');



		this.isOpen = null
	}
}, 
menu = { 
	toggle: function(btn){
		var span = btn.find('span'), 
			mnu = $('#'+btn.data('menu'))

		span.data('class') == undefined && span.data('class',span.attr('class'))
		var c = span.data('class') 
		
		if(mnu.is(':visible')){
			mnu.hide('slide',{ direction: 'right' })
			span.removeClass('lnr-cross').addClass(c)

			if(users.hay_cambios()) users.guardar()
			
		}else{
			$('.charm:visible').hide('slide',{ direction: 'right' })
			
			$('.lnr-cross') 
				.addClass(function(){
					return $(this).data('class')
			})	 
			.removeClass('lnr-cross')			

			mnu.show('slide',{ direction: 'right' })
			users.guardar_array()
			span.removeClass(c).addClass('lnr-cross')
		}
	 }, 


 }

 //FUNCIONNES
function sincronizar(dias, fecha, callback){
	var fecha = fecha || Fecha.general,
		datepicker = $('.datepicker')

	if (dias)
		fecha =  Fecha.calcular(dias, fecha)
	else
		dias = 0
	
	Fecha.general = Fecha.sql(fecha)
	Fecha.id = Fecha.number(Fecha.general)

	crearCita.horas.sincronizar()
	
	var diaFestivo = $.inArray(Fecha.md(Fecha.general),config.festivos)!=-1
	$.each(datepicker, function( index , me ){
		(diaFestivo)?$(this).addClass('c-red'):$(this).removeClass('c-red')

		$(this)
			.val(Fecha.print(fecha))
			.datepicker("setDate",Fecha.print(fecha))
	})	
 }
function validarFormulario(tipoObj,callback){ 
	return $('#crearCita [name="servicios[]"]:checked').length!==0&&$('#crearCita #cliente').val()!==""&&$('#crearCita [name="hora[]"]:checked').length!==0;
 }
function validarServicios(){
	var $ser = $('#crearCita [name="servicios[]"]:checked');
	if($ser.length==0){
		$('#login #crearCita [name="stepperServicios"]').popover('show');
		return false;
	}else{
		$ser.each(function(i,v){
			var txtSer=$(this).data('descripcion');
			$('#crearCita #lblSer').append(txtSer+', ');
		})
		crearCita.horas.pintar(Fecha.id);
		return true;
	}
 }
function logo(){
	if(existeUrl("../arch/logo.png")){
		var logo = "../arch/logo.png";
		$('#logo').prop('src',logo)
	}
 }


//INIT


$('body')
	.on('click','#eliminar',function(e){
		alert('Servicio no disponible, pongase en contacto con el administrador')
		return false
	})
	.on('click','.cancelar',function(e){
		e.stopPropagation();
		tile.close()
	})
	.on('click',".idDateAction",function(){
		if(!$(this).data('disabled')) sincronizar($(this).data('action'));
		})
	.on('click','#authEmail',function(){
		var $input = $(this).find('input:checkbox')
		$input.prop('checked',!$input.prop('checked'))
		})
	.on('click','.del',function(){
		let $cita =  $(this).parents('.cita')
		cita.del(
			$cita.attr('idCita'), 
			$cita.data('fecha'),
			$cita.data('hora'),
			$cita.data('agenda')
		)
		})
	.on('click','.tile, .tile-wide',function(){tile.open($(this))})