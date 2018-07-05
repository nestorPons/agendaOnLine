crearCita ={
	data : new Object(), 
	init : function(){
		var clase = $('#crearCita .contenedorServicios tbody tr').attr('class') ; 

		if (!$.isEmpty(clase)){
			var clase_id = clase.replace(/\D/g,'');
			crearCita.servicios.mostrar(clase_id) ;
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
		},
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
		init : function () {

			var clase = $('.menuServicios a').not('.ocultar_baja').attr('id')  ; 
			if (!$.isEmpty( clase )){
				clase_id = clase.replace(/\D/g,'')
				crearCita.servicios.mostrar(clase_id) ;
			 }
			
			},
	 },
	idUser : function () {
		var cli = $('#crearCita #cliente').val();
		var  nombre = normalize(cli);
		return parseInt($('#lstClientes [value="'+cli+'"]').text())||0;
	 }, 
	cliente: function (){
		//guardo cliente mediante formulario crearCita
		var $cliente = $('#crearCita #cliente'),
			nombre = $cliente.val()

		usuarios.guardar(-1,nombre)	
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

		dialog.open('dlgGuardar',self.guardar, dialog.close,function(){

			strServ = strServ.slice(0,-2)		
			data = {
				fecha : Fecha.general , 
				hora : crearCita.data.hora, 
				agenda : crearCita.data.agenda,
				nameCli :crearCita.data.nombre, 
				servicios : idSer ,
				nota : sec.find('#crearCitaNota').val(),
				tiempoServicios : parseInt(sec.find('#tSer').text()) 
			}
			$.extend(crearCita.data, data)

			$('#dlgGuardar')
				.find('#lblHora').html(data.hora).end()
				.find('#lblFecha').html(Fecha.print()).end()
				.find('#lblCliente').html(data.nameCli).end()
				.find('#lblSer').html(strServ)
				
		})
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
						main.lbl.create(self.data)

						mostrarCapa('main' , true )			
					}
				} else {
					echo(rsp)
					notify.error('Error inesperado')
				}
				dialog.close('dlgGuardar')
			},JSON)
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

			if (!$.isEmpty(crearCita.data.hora)){
				$('#crearCita .dia.activa').find('.horas[value="'+crearCita.data.hora+'"]').prop('checked',true)
				crearCita.dialog()
			}
	
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
		btn.load.reset()
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

		crearCita.data.hora = 'undefined';
		crearCita.data.agenda = 'undefined' 
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
				$('.tblHoras').show()
					
				_slider(crearCita.servicios.init) 

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
				&&crearCita.data.hora!='undefined';
		 },
		name : function () {
			var $this =  $('#crearCita #cliente');	
			var cliente = $this.val().trim();

			if(cliente!=""){
				str = normalize(cliente)
				var selCli = $('#lstClientes [data-name="'+str+'"]')

				if (selCli.length==0){
					$this.addClass('input-error');
					dialog.open('dlgCliente',crearCita.cliente)

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

$('#crearCita')
.on('click','a',function(){crearCita.servicios.mostrar($(this).attr('id'))})
.on('click','.idServicios',function(){
	let id = $(this).data('familia')
	$('#crearCita .menuServicios').each(function(){
		$(this)
			.find('.c3').removeClass('c3').end()
			.find('#'+id).addClass('c3')
	})
	})
	.on('click', '.horas', function(){
	crearCita.data.hora = $(this).val()
	})
.on('change','.lstServicios ',function(){crearCita.servicios.mostrar($(this).val())})
.on('click','.horas',crearCita.dialog)
.on('click','.siguiente',function(e){crearCita.stepper($('div [id^="stepper"]:visible').data('value') + 1);})
.on('blur','#cliente',crearCita.validate.name)
.on("swipeleft",'.tablas')
.on('click','.cancelar',function(){mostrarCapa('main')})
