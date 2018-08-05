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
		crearCita.load()
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
		return $('body').attr('iduser');
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
				nameCli :crearCita.data.nombre, 
				servicios : idSer ,
				nota : sec.find('#crearCitaNota').val(),
				tiempoServicios : parseInt(sec.find('#tSer').text()) 
			}
			$.extend(crearCita.data, data)

			$('#dlgGuardar')
				.find('#lblhora').html(data.hora).end()
				.find('#lblfecha').html(Fecha.print()).end()
				.find('#lblCliente').html(data.nameCli).end()
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
						historial.reset()
    					cerrarMenu()	
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

			for(let i = 0 ; i <= document.margenDias ; i++){
	
				var date = Fecha.calcular(i ,  Fecha.id )
				crearCita.horas.crear(Fecha.number(date))
			}
			
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
		crear: function (id_table, callback){
			var data = {
				agenda: crearCita.data.agenda,
				fecha:id_table , 
				controller : 'crearCita.horas'}

			if ($('#crearCita #'+id_table).length) $('#crearCita #'+id_table).remove()
					
			$.post(INDEX , data , function(html){
				var m = document.getElementById('tablas')
				m.innerHTML = html	
				crearCita.horas.load()
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
		sincronizar: function(callback){

			var context = $('#tablas')
			var activa = context.find('.activa')
			var activar = context.find('#'+ Fecha.id)

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
				crearCita.data.cliente = crearCita.idUser
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
	numeracion:function(){
		var num = $('section#historial div.cita').length
		$('#lblHis').html(num)
	 },
	 reset: function(){
		var data = {
			controller : 'users', 
			action: 'view', 
			section: 'historial'
		}
		$.post(INDEX, data,function (html, textStatus, jqXHR) {
			$('section#historial').find('#lineasHistorial').html(html)
			historial.numeracion()
		},'html')
	 }, 
	 del: function(id){
		$('.cita[idCita="'+id+'"]').hide('explode').remove()
	 }
 }
var cita = {
	del : function (id) {
		var data = {
			controller: 'cita', 
			action: DEL, 
			id: id
		}

		
		$.post(INDEX, data,function (r, textStatus, jqXHR) {
			r.success && historial.del(id)
		},'json')
		
	 },
	add : function () {
	 }
 }
var usuario = {
	data: new Object,
	last:  new Object,
	guardar_array: function(){
		this.last = this.data

		this.data = {
			nombre:$('#nombre').val() ,
			email:$('#email').val(),
			tel:$('#tel').val(),
			authEmail : $('#authEmail').find('input:checkbox').prop('checked')?1:0, 
			authCal : $('#authCal').find('input:checkbox').prop('checked')?1:0, 
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
		$('#authCal').is('checked',this.last.authCal) 
	 }, 
	guardar: function($this){
		usuario.guardar_array()
		var opass = $('#opass').val(),
			npass = $('#npass').val(),
			rpass = $('#rpass').val()
		
		if(!$.isEmpty(opass)) {
			if(usuario.validar.pass(opass, npass, rpass)){
				notify.error('Al cambiar la contraseña' , 'ERROR CONTRASEÑA')	
				return false 
			} else {
				this.data.opass = SHA(opass)  
				this.data.npass = SHA(npass) 
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
				usuario.revertir_cambios()
			}
		 })	
		.fail(function(r){
			notify.error('No se han podido guardar los datos')
			usuario.revertir_cambios()
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
menu = {
	toggle: function(btn){
		var span = btn.find('span'), 
			mnu = $('#'+btn.data('menu'))

		span.data('class') == undefined && span.data('class',span.attr('class'))
		var c = span.data('class') 
		
		if(mnu.is(':visible')){
			mnu.hide('slide',{ direction: 'right' })
			span.removeClass('lnr-cross').addClass(c)

			if(usuario.hay_cambios()) usuario.guardar()
			
		}else{
			$('.charm:visible').hide('slide',{ direction: 'right' })
			
			$('.lnr-cross') 
				.addClass(function(){
					return $(this).data('class')
			})	 
			.removeClass('lnr-cross')			

			mnu.show('slide',{ direction: 'right' })
			usuario.guardar_array()
			span.removeClass(c).addClass('lnr-cross')
		}
	 }
 }
$(function(){	
	$('body')
		.on('click','.cancelar', cerrarMenu)
		.on('click',".idDateAction",function(){
			if(!$(this).data('disabled')) sincronizar($(this).data('action'));
		 })
		.on('click','#authEmail, #authCal',function(){
			var $input = $(this).find('input:checkbox')
			$input.prop('checked',!$input.prop('checked'))
		 })
		.on('click','.del',function(){
			cita.del($(this).parents('.cita').attr('idCita'))
		 })
		
	$('#navbar')
		.on('click','#btnConfig, #btnDatos',function(){
			menu.toggle($(this))
		 })
	$('input:password').blur(function(){
		var pass1 = $('#pass').val()		
		var pass2 = $('#rpass').val()
		validarPass(pass1,pass2)

	 })

	$('.tile-content').click(function(e){menuAbrir($(this).parent())})
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
		.find('#btnCancelarDlg')
			.click(function(){closeDialog('#crearCita #dlgCliente')})
		
	$('#historial')
		.find('#tableHistory').on('click','.fnDel',function(){
			cita.del($(this).parent().attr('idSer'))
		 })
	$('#calNotas').click(function(e){cargarCalendario()})
	$('#usuarioFrm')
		.submit(function(e){usuario.guardar(e,$(this))})
		.on('blur','#oldPassFake',function(){
			$('#oldPass').val(SHA($(this).val()))
			usuario.comprobarContraseña($('#oldPass'));
		 })
		.on('change','#oldPassFake',function(){
			$(this).removeClass('input-error input-success');
		 })
		.on('blur','#passFake',function(){
			$('#pass').val(SHA($(this).val()))
		 })
		.on('blur','#rpassFake',function(){
			$('#rpass').val(SHA($(this).val()))
		 })
	$('#eliminar').click(function(){eliminarUsuario()})
	
	//fnReloj()
	cargarDatepicker()
	crearCita.init()
	historial.numeracion()
 })
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
	
	var diaFestivo = $.inArray(Fecha.md(Fecha.general),FESTIVOS)!=-1
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
function menuAbrir($this){
	if ($this.find('.contenido').css('display')!='block'){
		cerrarMenu($this);
		$this
			.prependTo('#contenedorMenuPrincipal')
			.find('.mensaje').hide().end()
			.find('.contenido ')
				.show()
				.css({'cursor':'initial'});
		resize($this);
	}
 }	
function resize(that){
	var ancho = $('#login').width();
	var alto = $(that).find('.contenido').height();
		$(that).animate({
		height: alto,
		width: ancho,
	},function(){
		alto = $(that).find('.contenido').height();
		$(that).animate({	
			height: alto,
		})
	})
 }
function cerrarMenu(){
	var $this = $('.tile-active')
	crearCita.stepper(0)
	
	if(typeof(ancho) != "undefined"){
		$last.animate({
			height: alto,
			width: ancho
		},750)
		$last.removeAttr('style')
	 }
	$last = $this
	ancho = $this.width()
	alto = $this.height()
	
	$('.mensaje').show()
	$('.contenido').hide()
	$("input:checkbox").attr('checked', false)
	$('.dialog').hide()
	$('.popup-overlay').hide()
	$('#crearCita input[name="hora[]"]:checked').prop('checked',false)
 }
function fnReloj(){
	var reloj=new Date();
	var horas=reloj.getHours();
	var minutos=reloj.getMinutes();
	var segundos=reloj.getSeconds();
	// Agrega un cero si .. minutos o segundos <10
	minutos=_revisarTiempo(minutos);
	segundos=_revisarTiempo(segundos);

	document.getElementById('reloj').innerHTML=horas+":"+minutos+":"+segundos;
	tiempo=setTimeout(function(){fnReloj()},500); 
	/*en tiempo creamos una funcion generica que cada 
	500 milisegundos ejecuta la funcion fnReloj()*/
	function _revisarTiempo(i){
		if (i<10)i="0" + i;
		return i;
		/*Esta funcion le agrega un 0 
	a una variable i que sea menor a 10*/
	} 
 }