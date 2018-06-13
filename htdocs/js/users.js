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
	tiempoServicios : 0 ,
	data : new Object() , 
	init : function(){

		var clase = $('#crearCita .contenedorServicios tbody tr').attr('class') ; 
		if (!$.isEmpty(clase)){
			clase_id = clase.replace(/\D/g,'');
			servicios.mostrar(clase_id) ;
		}
		cargarDatepicker();
	 },
	idUser : function () {
		var cli = $('#crearCita #cliente').val();
		var  nombre = normalize(cli);
		return parseInt($('#lstClientes [value="'+cli+'"]').text())||0;
	 }, 
	cliente: function (){
		
		var nombre = $('#crearCita #cliente').val();
		usuarios.guardar(0,nombre,btn.load.hide);
	 },
	dialog: function (){
		var self = crearCita , sec =  $('#frmCrearCita') , 
			idSer = new Array() ,
			strServ ="" 

		sec.find('[name="servicios[]"]:checked').each(function(){
			strServ += $(this).siblings('label').find('.descripcion').text() + ", ";
			idSer.push($(this).val())
		})

		dialog.open('dlgGuardar',self.guardar, dialog.close,function(){
			strServ = strServ.slice(0,-2);			
			data = {
				fecha : Fecha.general , 
				hora : sec.find('.horas:checked').val() , 
				agenda : sec.data.agenda,
				nameCli :sec.data.nombre, 
				servicios : idSer ,
				nota : sec.find('#crearCitaNota').val()  ,
				uTiempo : Math.ceil(parseInt(sec.find('#tSer').text()) / 15) 
			}
			$.extend(crearCita.data, data)

			$('#dlgGuardar')
				.find('#lblhora').html(crearCita.data.hora).end()
				.find('#lblfecha').html(crearCita.data.fecha).end()
				.find('#lblCliente').parent('p').html('Reserva la cita')
				$('#lblSer').parent('p').empty()//html(strServ).end()
		})

	 },
	guardar: function(){
		var self = crearCita 
		self.data.controller = 'cita'
		self.data.action = 'save'
		self.data.cliente = $('body').attr('idUser')
		
		if(self.validate.form()){
			$.post(INDEX,crearCita.data,function( rsp ){

				if(rsp.ocupado){

					notify.error( rsp.mns.body , rsp.mns.tile );

				}else{	

					notify.success('Cita reservada conéxito' , 'Guardado' );
					self.data.idCita = rsp.idCita
					self.data.servicios = rsp.services
					cerrarMenu()

				}

				$('.dia').remove()
				dialog.close('dlgGuardar');
			},'json')
			.fail(function( jqXHR, textStatus, errorThrown){
				notify.error('Error enviando los datos');
				echo (jqXHR)
				return false;
			})
		}else{
			notify.error('Complete todos los datos');
			return false;
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
		load : function ($this) {
			var lblTS = $('#tSer')[0]
		
			if( $this.is(':checked') )
				crearCita.tiempoServicios += $this.data('time')
			else 
				crearCita.tiempoServicios -= $this.data('time')

			crearCita.horas.pintar(Fecha.id)
		
			lblTS.innerHTML = crearCita.tiempoServicios;
		 } ,

		crear: function (id_table, callback){
			var data = {
				agenda: crearCita.data.agenda,
				fecha:id_table , 
				controller : 'crearCita.horas'}

			$.post(INDEX,data,function(html){
				
				$('#tablas')
					.fadeOut(function(){
						$(this)
							.html(html)
							.fadeIn()
						crearCita.horas.pintar(id_table)				
						typeof callback == "function" && callback()
					})

			},'html')

		 },		
		pintar: function(id_table){

			var self = crearCita, 	
				section = $('#crearCita') 
			section.find('#tablas .reservado').removeClass('reservado').find('input').attr('disabled',false)

			var horas = crearCita.horas ,
				_esPasada = function( hora ) {
				
	 			var diff_fechas = Fecha.restar(id_table); 
				//sumo los minutos a la fecha actua
				var _return = false;
				
				if ( diff_fechas<0 ){

					_return = true
					
				} else if ( diff_fechas == 0 ){
					
					var minTime = document.minTime * 60000;
					var a = new Date(hora*1000);
					var milisegundos = new Date().getTime();
					var f = new Date(milisegundos + minTime);

					_return =  (a<f)
					
				}
				return  _return
			},
				ts = parseInt(Math.ceil(self.tiempoServicios/15))||0 ,
				_reservar= ( me ) =>  me.attr('disabled',true).parent('label').addClass('reservado') ,
				_fueraHorario  = ( me ) =>  me.hasClass('disabled') ,
				diaFestivo = !$.inArray(Fecha.md(id_table),FESTIVOS) ,
				count = ts ,
				horas = section.find('#'+ id_table+' .horas')

			for (let i = horas.length - 1  ; i >= 0 ; i--){
				let $this = section.find('#'+ id_table+' #hora'+i)
				
				if (diaFestivo ){
					_reservar($this) 
				}else{
					if ( $this.hasClass('ocupado')) count = ts 

					if ( count > 0 ) _reservar($this) 
					count -- 
				}
			}
		 },
		sincronizar: function(callback){

			var context = $('#tablas'),
				activa = context.find('.activa'),
				activar = context.find('#'+ Fecha.id),
				_toggle = function(){
					activa.removeClass('activa')
					activar.addClass('activa')
					context.fadeIn() 
				}
			context.fadeOut(function () {

				if(!activar.length) {
					crearCita.horas.crear(Fecha.id, function(){
						activar = context.find('#'+ Fecha.id)
						_toggle()
					})
				 } else {
					_toggle()
				 }

			})
		 },
	 },
	reset: function(){
		$('.steperCapa li').hide(function(){
			$('#step0').show()
		});
		_hora =0 ;
		btn.load.reset();
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

			dialog.close('dlgGuardar');
	 },
	stepper: function(index){
		var $visible = $('.steperCapa:visible'),
			$stepper = $('#stepper'+index)

		if($visible.attr('id')==$stepper.attr('id'))return false;
		if (!$stepper.is(':visible')&&$visible.length){
			if(index==0){
				_slider()

			}else if(index==1){
				crearCita.data.agenda = $('#crearCita').find('input[name="agenda[]"]:checked').val()
				crearCita.data.nombre =  $('#crearCita #cliente').val() 
				$('.tblHoras').empty()

				_slider() 

			} else if(index==2&&crearCita.validate.service()){
				_slider()

			}
		}
		function _slider(callback){
			var dir = $visible.data('value')>0||1
			var dirEntrada = index-dir<0?'right':'left'
			var dirSalida = dirEntrada=='right'?'left':'right'

			$('.stepper') //esto es para colorear el stepper activo
				.find('li').removeClass('current').end()
				.find('#step'+index).addClass('current')
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
			var $this =  $('#crearCita #cliente');	
			var cliente = $this.val().trim();

			if(cliente!=""){
				str = normalize(cliente)
				var selCli = $('#lstClientes [data-name="'+str+'"]')

				if (selCli.length==0){
					$this.addClass('input-error');

					dialog.create('dlgCliente',crearCita.cliente, null ,function(){
						dialog.open('dlgCliente');
					})

				}else{
					crearCita.data.cliente = selCli.data('id') 
					$('#crearCita #lblCliente').html($this.val())
					$this
						.removeClass('input-error')
						.addClass('input-success');	

					return true;
				}

			}else{
				$this
					.addClass('input-error')
					.removeClass('input-success');
				$this.popover('show');
				return false;
			}
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
		var num = $('#historial #tableHistory tr').length
		$('#lblHis').html(num)
	},
	row: function (data) {
		var html = "" ,
			table = document.getElementById('tableHistory'),
			count = data.idCitaSer.length - 1 
			_insert = function(idCitaSer, idSer, idCita, fecha , hora, des){
				html += "\
					<tr id=tr"+idCitaSer+" \
						class="+ idCitaSer + idSer + " \
						idCita="+  idCita + " \
						idser=" +idSer+ " \
						fecha=" + fecha + " \
						hora="+ hora + "> \
						<td idSer="+idCitaSer+">\
							<i class='icon-cancel fnDel'></i>\
							<i class='icon-load c5 animate-spin hidden'></i>\
						</td>\
						<td class='padding5'>"+fecha+" a las "+hora+"</td>\
						<td class='padding5 aling-left'>"+des+"</td> \
					</tr>"
			}

		for (i = 0; i <= count; ++i) {
			var descripcion = 
				$('.contenedorServicios').find('#rowServicios'+data.servicios[i]).find('.descripcion').text()
								
			_insert(data.idCitaSer[i],data.servicios[i],data.idCita,data.fecha,data.hora,descripcion)
		}
		table.innerHTML = table.innerHTML + html
		historial.numeracion()
	}
 }
var cita = {
	del : function (id) {
		var $this = $('#tr'+id), 
			fecha =  Fecha.number($this.attr('fecha')), 
			hora = $this.attr('hora'),
			idSer = $this.attr('class'),
			$rows = $("#tableHistory ."+idSer),
			idCita = $this.attr('idCita')
			data = {
				id : idCita,
				idCitaSer: id,
				controller : 'cita' , 
				action : DEL , 
			}
		$.ajax({
			type: "POST",
			dataType: "json",
			data: data, 	
			url: INDEX,
			beforeSend: function (){
				$rows
					.fadeTo("slow", 0.30)
					.find('.icon-cancel').hide().end()
					.find('.icon-load').css('display','inline-block')
			},
		 })	
		.done(function(r){	
			if (r){
				$rows.fadeOut('slow',function(){
					$(this).remove()
					crearCita.del(Fecha.number(data.fecha))
					historial.numeracion()
				})
			/*	$('#tf'+fecha+' #'+hora+' label').removeClass('reservado')
					.find('input').attr("disabled", false)
			*/
			}
		 })
	 },
	add : function () {
	 }
 }
var usuario = {
	controller : 'users', 
	guardar: function(e,$this){
		e.preventDefault()

		var opass = $('#opass').val(),
			npass = $('#npass').val(),
			rpass = $('#rpass').val(),
			data = {
				nombre:$('#nombre').val() ,
				email:$('#email').val(),
				tel:$('#tel').val(),
				controller : usuario.controller , 
				action : SAVE
	        }
		
		if(!$.isEmpty(opass)) {
			if(usuario.validar.pass(opass, npass, rpass)){
				notify.error('Al cambiar la contraseña' , 'ERROR CONTRASEÑA')	
				return false 
			} else {
				data.opass = SHA(opass)  
				data.npass = SHA(npass) 
			}
		}
		$.ajax({
			type: "POST",
			data: data,
			url: INDEX,
			dataType: 'json',
		})
		.done(function(rsp,status){
			if(rsp){
				$('#lblUser').html($('#nombre').val())
				$('#lblUser').val($('#config #usuarioFrm #nombre').val()) 
				notify.success('Sus datos han sido guardados','Guardado')
				cerrarMenu()
			}else{
				notify.error('No se han podido guardar los datos')
			}
			btn.load.hide()
		})	
		.fail(function(r){console.log("ERROR=>"+r.success)})
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
 }
$(function(){	
	$('body').on('click',".idDateAction",function(){
		if(!$(this).data('disabled')) sincronizar($(this).data('action'));
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
		.on('click','.cancelar', cerrarMenu)	
		.on('click','.horas',crearCita.dialog)
		.on('click','.idServicios',function(){crearCita.horas.load($(this))})
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

	fnReloj()
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
	btn.load.reset()
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