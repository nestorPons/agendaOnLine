'strict'
//Funcion para menu responsive 
//No se puede sobreesctribir la funcion en jquery asi que tengo que hacer una funcion suelta
function menuEsMovil(tab){
	$('.esMovil .dia').find('[agenda]:visible').hide()
	$('.esMovil .dia').find('[agenda="'+tab.attr('agenda')+'"]').show()

	return true
 }
function sincronizar( dias, date , callback ){
	if(main.cargado){
		var fecha = date||Fecha.general ,
			$datepicker= $('.datepicker')

		if (dias)
			fecha =  Fecha.calcular(dias, fecha);
		else
			dias = 0;
		
		Fecha.anterior = Fecha.general
		Fecha.general = Fecha.sql(fecha)
		Fecha.id = Fecha.number(Fecha.general)
	
		colorearMenuDiasSemana();

		//Sincronizamos el panel principal
		main.sincronizar(dias)
		//Sincronizamos las notas
		notas.sync(Fecha.general)
		//Sincronizamos crearCita
		if(typeof crearCita.horas=='object') crearCita.horas.sincronizar()
		//Sincronizamos historial
		if(typeof historial.sinc=='function') historial.sinc()

		var diaFestivo = $.inArray(Fecha.md(Fecha.general),FESTIVOS)!=-1;


		(diaFestivo)?$datepicker.addClass('c-red'):$datepicker.removeClass('c-red')

		$datepicker
			.val(Fecha.print(fecha))
			.datepicker("setDate",Fecha.print(fecha));

		$('.tabcontrol').tabcontrol()
	}
 }
function mostrarCapa(capa, callback){

	var data = { 
		controller : capa ,  
		fecha :  Fecha.sql ,
	 }, 
	 $capa = $('#'+capa)
	if($capa.is(':visible')) return false;
	$('#chckOpUsersDel').prop( "checked", false ) ;
	$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja') ;

	if($capa.is(':empty') ){
		$.post(INDEX,data,function(html){

			$('#'+capa).html(html).promise().done(__INIT__);
			function __INIT__ (){
				capa=='notas' && notas.init()
			}
			$.getScript("/js/"+capa+".js")

		},'html')
	 } else {
		
		capa=='crearCita' && crearCita.load()

	 }
	if($('#config').is(':visible')&&config.change) config.guardar();
	if($('#agendas').is(':visible')&&agendas.change) agendas.guardar();
	if($('#crearCita').is(':visible')) crearCita.reset();

	$('.capasPrincipales').hide()
	$capa.fadeIn()

	menu.status(capa)

	if(capa=='main') $('#'+Fecha.id).show()
		
	btn.load.reset()

	$('html,body').animate({scrollTop:0}, 500)
	
	//Titulo de la seccion
	$('#navbar').find('#tile_seccion').text($capa.data('nombre'))

	typeof callback == "function" && callback()
 }
function sliderConfigBorder ( value, slider ) {
	estilos.test( value ) 
 }	
var 
main ={	
	section : $("#main") , 
	body : $('#main .cuerpo') ,
	z_index : 2 ,
	data : new Object(), 
	arrSer : new Array(), 
	last : new Object(),
	idsControl : new Object(),
	idCita : -1,
	login: {
		ancho : 0 
	 }, 
	cargado : true, 
	set: {
		nameAgenda : function(id, name){
			$('#nombreagenda' + id).text(name);
		 }, 
		data : function (idCita){
			var lbl = $('#idCita_'+idCita+'.lbl')

			main.data[idCita] = {
				idCita : idCita ,
				agenda : lbl.parents('.celda').attr('agenda'),
				cliente :  { 
					id : lbl.find('.nombre').attr('id') , 
					nombre : lbl.find('.nombre').text().trim()
				 },
				fecha :  Fecha.sql(lbl.parents('.dia').attr('id')) ,
				hora : lbl.parents('tr').data('hour') ,
				obs :  lbl.find('.note').text().trim() ,
				servicios : new Array() ,
				tiempoServicios :parseInt(lbl.attr('tiempo'))
			 }

			lbl.find('.codigo').each(function(i,o){
				var id =$(this).attr('id_codigo') , 
					codigo = $(this).html() , 
					descripcion = $(this).attr('des_codigo') ,
					tiempo = $(this).attr('tiempo')

				main.data[idCita].servicios.push({id ,  codigo ,  descripcion , tiempo})
				main.arrSer.push({id ,  codigo ,  descripcion , tiempo}) 
			 })
		  }, 
		tiempoServicios : function(){
			var ts = main.data[main.idCita].tiempoServicios <0 ? 10: main.data[main.idCita].tiempoServicios
			$('#dlgEditCita').find('#tiempoServicios').val(ts)
		 }
	 }, 
	sincronizar: function (dir){
		main.cargado = false
		var section = main.section , 
			body = main.body, 
			_pasarDia = function(dir){
				if (Fecha.id != section.find('.dia.activa').attr('id')) {
					var dir= dir||0,
						ent = (dir>0||dir=='right')?'right':'left',
						sal = (ent=='right')?'left':'right'
			
					body.hide("slide", { direction: sal }, 750,function(){
						$('.dia.activa').removeClass('activa')
						section.find('#'+ Fecha.id).addClass('activa')
						body.show("slide", { direction: ent }, 750)

						main.inactivas.comprobar()
						main.cargado = true
					})
				} 	
				$('.tabcontrol').tabcontrol()
			}

		if (!section.find('#'+Fecha.id).length)
				main.crearDias(_pasarDia)
			else{
				main.check()
				_pasarDia()
			}


	 },
	activeDay : function () {
		$('.activa').removeClass('activa')
		$('#' + Fecha.id).addClass('activa')
	 }, 
	check : function () {

		var _citas = function(){
				var citas = new Array();
				$('#'+Fecha.id).find('.lbl').each(function(){
					//if (!$.isEmpty($(this).attr('lastmod') ))
						citas.push({
							'id':$(this).attr('idcita'),
							'lastMod':$(this).attr('lastmod')
						 })
				})
				
				return citas
			 },
			data = {
				controller : 'cita' ,
				action : 'check',
				citas : _citas(),
		 		fecha : Fecha.general
			  },
			_getData = function(arr, isDel ,isAdd ){
				$.each(arr,function(i,dataEdit){
					var data = dataEdit[0] , tt = 0 
					//Se declaran dos variables para adecuarlo al antiguo formato
					data.idCita = data.id
					data.nota = data.obs

					data.servicios = dataEdit[1]
					$.each(data.servicios, function( index, $this ){
						tt += parseInt($this.tiempo)
					})

					if (isDel) main.lbl.delete(data.idCita ,true)
					if (isAdd) main.lbl.create(data)
				})
			}

		$.ajax({
			type:"POST",
			url: INDEX ,
			dataType: 'json',
			data: data,
			cache: false
		})
		.done(function(r){
			
			if (!$.isEmpty(r.del)){
				$.each(r.del,function(i,value){
					main.lbl.delete(value ,true)
				})
			 }
			if (!$.isEmpty(r.add)){ 
				_getData(r.add, false, true)
			 }
			if (!$.isEmpty(r.edit)){
				_getData(r._edit, true, true)
			 }
			
		},'json')
		
	 },
	crearDias: function(callback){

		var self = this , section = this.section , body = this.body 
		var mD = parseInt(document.margenDias)/2;
		var fechaIni = Fecha.calcular(-1*mD,Fecha.general);
		var fecha = fecha||Fecha.general;
		var dias = body.find('.dia')
		var ids = new Array();

		// Se crea array de dias cargados
		$.each(dias,function(){
			ids.push($(this).attr('id'));
		})
		
        
		$.ajax({
			type:"POST",
			url: INDEX ,
			dataType: 'html',
			data: {
				fecha : Fecha.general ,
				ids : ids ,
				controller : 'main' ,
				action : VIEW
			},
			cache: false
		})
		.done(function(html){
			body.append(html)
		 
			main.lbl.load()
			typeof callback == "function" && callback()
		}).fail(function(r,status){console.log("Fallo refrescando=>"+status)});
		
	 },
	citasSup: function($this){
		var $celda = $this.parents('.celda');
		var idCita = new Array();
		$celda.find('table:visible')
			.hide('blind',function(){
				var $this = $(this).next().length?$(this).next():$(this).prev();
				$this
					.show('blind')
					.find('.icon-attention')
						.show().end()
					.parent()
					.removeClass('color1 color2')
					.addClass($this.data('color'));
			})
	 },

	save: function(data, callback){

		data.controller= 'cita'
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: INDEX,
			data: data,
		})
		.done(function(r){
			if (r.success) {
				typeof callback == "function" && callback()
			}else{
				notify.error ('No se pudo guardar.')
			}
		})
		.fail(function(r){console.log(r)})

	 },
	responsive: function($this){
		var a = $this.val();
		$('.cuerpo').fadeOut('fast',function(){
			$('.dia .celda').not('.num').addClass('hiddenim')
			$('#main .agenda'+a).removeClass('hiddenim')
			$('.cuerpo').fadeIn('fast')
		})
	 },
	edit : function (idCita, idCelda ) {
		if (!idCita)  return false
		main.idCita = idCita

		var lbl = $('#idCita_'+main.idCita+'.lbl') 
		main.lbl.obj= lbl

		main.set.data(main.idCita)

		main.last = {
			idCita : main.data[main.idCita].idCita,
			agenda : main.data[main.idCita].agenda,
			tiempoServicios : main.data[main.idCita].tiempoServicios , 
			hora : main.data[main.idCita].hora , 
			fecha : main.data[main.idCita].fecha, 
			cliente : {
				id : main.data[main.idCita].cliente.id, 
				nombre : main.data[main.idCita].cliente.nombre
			},
			obs : main.data[main.idCita].obs 
		 }
	
		var _addServiceToLbl = function (callback){

			var arrSer = main.data[main.idCita].servicios, 
				lblSer = main.lbl.obj.find('.servicios'),
				html = ''
			lblSer.empty() 

			for(let i = 0 ; i < arrSer.length ; i++){
				let self = arrSer[i]

				var dataArrSer = {
					id : self.id,
					codigo : self.codigo , 
					idCita : self.idCita ,
					descripcion : self.descripcion ,
					tiempo : self.tiempo
				}
				html += main.lbl.service( dataArrSer )
			}

			lblSer.html(html)

			main.lbl.obj.removeClassPrefix('row_').addClass('row_'+
				Math.ceil(main.data[main.idCita].tiempoServicios / 15) 
			)
	
			typeof callback == "function" && callback();
		 }
		var _delRow = function(div){
			var cod = div.find('.codigo')
			var idCod = cod.attr('id_codigo')

			main.data[main.idCita].tiempoServicios -= cod.attr('tiempo')

			var arrSer = main.data[main.idCita].servicios
			var index = arrSer.indexOf(idCod)

			main.data[main.idCita].servicios.splice(index, 1)
			div.fadeOut('fast').remove()

			main.set.tiempoServicios()
		 }
		var _addRow = function (id , codigo , descripcion ,tiempo, callback ){
			var $dlg = $('#dlgEditCita')
			
			$dlg.find('.template')
				.clone()
					.removeClass('template')
					.find('.codigo')
						.attr('id_codigo',id)
						.html(codigo + " => ")
						.attr('tiempo',tiempo)
					.end()
					.find('.descripcion')
						.html(descripcion)
					.end()
					.appendTo($('#dlgEditCita').find('#codigos'))
					.on('click','.fnDelSer',function(){
						_delRow($(this).parent())
					})
			typeof callback == "function" && callback()
		 }
		var _eventAddService = function () {
			
			$('#dlgEditCita').on('change','#lstServ',function(){
				var select  = $(this).find(':selected')
					id = select.val() , 
					codigo = select.attr('codigo') , 
					descripcion = select.text() , 
					tiempo = select.attr('tiempo')

				main.data[main.idCita].servicios.push({id ,  codigo ,  descripcion , tiempo})
				main.data[main.idCita].tiempoServicios += parseInt(tiempo)	
				_addRow (id ,  codigo ,  descripcion , tiempo, main.set.tiempoServicios)


				$(this).val('')
			})
		 }
		var _save = function () {
			var dlg = $('#dlgEditCita') , duration = 0 , arrIdSer = new Array() ,data = new Array()

			dlg.find('input').each(function(i,v){
				data[$(this).attr('id')] = $(this).val()
			})

			let str = normalize(data['cliente']), 
				selCli = $('#lstClientes [data-name="'+str+'"]')

			main.data[main.idCita].cliente.id =  selCli.data('id')
			main.data[main.idCita].cliente.nombre =  selCli.val()
			main.data[main.idCita].fecha = data['fecha']
			main.data[main.idCita].hora = data['hora']
			main.data[main.idCita].obs = data['obs']
			main.data[main.idCita].tiempoServicios = data['tiempoServicios']

			$.each(main.data[ main.idCita].servicios, function( i , v){

				arrIdSer.push(v.id)

			})

			var sendData = {
				action : EDIT ,
				idCita :  main.idCita ,
				agenda : main.data[ main.idCita].agenda ,
				idUsuario : main.data[ main.idCita].cliente.id || false ,
				fecha :  Fecha.sql(dlg.find('#fecha').val()) ,
				hora : dlg.find('#hora').val() ,
				obs :  dlg.find('#obs').val(),
				servicios : arrIdSer ,
				status : false , 
				tiempoServicios: main.data[main.idCita].tiempoServicios
			}

			main.save(sendData,function(){
				main.lbl.edit(main.data[main.idCita], main.last)
				_addServiceToLbl(function(){
					dialog.close('dlgEditCita')
					if(!$.isEmpty(sendData.obs)) {
						main.lbl.obj
							.find('.text_note').text(sendData.obs).end()
							.find('.note').addClass('show')
					}else{
						main.lbl.obj
							.find('.text_note').text(sendData.obs).end()
							.find('.note').removeClass('show')
					}
				})
				
			})		
		 }

		if (!$.isEmpty(idCelda)) { 

			// se ha editado arrastrando label
			let decode = generateId.decode(idCelda)
			main.data[main.idCita].agenda = decode.agenda
			main.data[main.idCita].fecha = decode.date
			main.data[main.idCita].hora = decode.hour
			
			//Hay que adecuar el array servicios para mandar solo los id 
			let edata = main.data[main.idCita],
				len = main.data[main.idCita].servicios.length,
				ser = main.data[main.idCita].servicios
			
			edata.servicios = new Array ;
			edata.idUsuario =edata.cliente['id']
			delete edata['cliente']
			for (let i = 0; i < len; i++) {
				edata.servicios.push(ser[i].id)
			 }
			edata.action = EDIT

			main.save(edata)

		 } else {		

			var 
			fnCancel = function(){
				main.del(main.data[main.idCita].idCita)
			 }, 
			callback = function(isNew){

				var section = $('#dlgEditCita')

				$('#dlgEditCita #codigos').html('') 

				section
					.data('idCita',main.idCita)
					.find('#id').val(main.idCita).end()
					.find('#cliente')
						.val(main.data[main.idCita].cliente.nombre)
						.end()
					.find('#obs')
						.val(main.data[main.idCita].obs||'')
						.end()
					.find('#fecha')
						.val(main.data[main.idCita].fecha)
						.end()
					.find('#hora')
						.val(main.data[main.idCita].hora)
					.find('#tiempoServicios')
						.val(main.data[main.idCita].tiempoServicios)
						
				$.each(main.data[main.idCita].servicios , function(i,a){
					_addRow( a.id , a.codigo , a.descripcion , a.tiempo,  main.set.tiempoServicios)
				})

				if (isNew) _eventAddService()
				
				lastTime = main.data[main.idCita].tiempoServicios

			 }

			dialog.open('dlgEditCita',_save, fnCancel,  callback)
			
		 }
	 },
	del: function(idCita){
		data = {
			id : idCita , 
			action : 'del' , 
			controller : 'cita', 
			fecha : Fecha.sql(Fecha.general)
		 }	

		if (main.lbl.delete(data.id)){
			$.post(INDEX,data,function(r){

				if 	(r.success) {
					$('#lstChckSer').empty();
					$('#dlgEditCita').removeData('idCita')
					dialog.close('dlgEditCita')
				}

			},'json')
			.fail(function( jqXHR, textStatus, errorThrown ) { echo (jqXHR.responseText) });
		 }

	 },
	guardarNota: function($this){
		var txt = $this.find('input').val();
		var id = $this.parents(':eq(3)').attr('idcita')

		if (!$.isEmpty(txt)){
			$this.find('.icon-load').fadeIn();
			$.get(INDEX,{id:id,txt:txt},function(r){
				if (r.success){
					$this.find('.icon-ok').fadeIn()
					setTimeout(function() {
						$this.find('.icon-ok').fadeOut()
					},3000);

				}else{echo(r)}
			})
			.always($this.find('.icon-load').fadeOut());
		}
	 },
	unidadTiempo : function(tiempoServicios ){

		return Math.ceil(tiempoServicios / 15)
	 }, 
	inactivas:{ 
		click :	function(){
			var status = localStorage.getItem("showRows")==1||$('.dia.activa').find('.fuera_horario').is(':visible')?0:1
			main.inactivas.change(status)
	
		},
		change :function (std, save = true){
			if( std == 1 ){			
				$('#btnShow')
					.find('.menulbl').html('Ocultar').end()
					.find('.on').show().end()
					.find('.off').hide().end()
				$('#main .disabled').removeClass('disabled');
			}else{			
				$('#btnShow')
					.find('.menulbl').html('Mostrar').end()
					.find('.off').show().end()
					.find('.on').hide().end()
				$('#main .fuera_horario').parent().addClass('disabled')

			}	
			if(save) localStorage.setItem("showRows", std)		
		}, 
		comprobar : function(){
			//Si hay una cita fuera de horario que se muestren las celdas fuera de horario
			if($('#'+Fecha.id).find('tr').find('.fuera_horario').find('.lbl').length) 
				main.inactivas.change(true, false)
			else
				if(localStorage.getItem("showRows")==0) 
					main.inactivas.change(false, false)
		}	
	 },
	lbl:{
		widht :  '25' ,
		height: new Array,
		clone : new Object, 
		idLastcelda : 0 ,
		obj : new Object, 
		load: function(){
			main.lbl.draggable()
			main.lbl.droppable()
		 }, 
		create: function(data){
	
			//agenda,fecha,hora,idCita,idUsuario,nota,servicios.id
			var lbl = main.lbl,
				htmlSer = '', 
				idCelda =  generateId.encode( data.agenda , data.fecha , data.hora ), 
				celda = document.getElementById(idCelda)

			$.each(data.servicios, function ( id , serv ) {
				htmlSer += lbl.service(serv)
			})

			celda.innerHTML = lbl.container(data , htmlSer)
			lbl.style()
		 },
		edit: function (data, last){
			var idCita = data.idCita , object = $('#main').find('#idCita_'+idCita)
			main.lbl.obj.attr('tiempo',  data.tiempoServicios )

			if (data.cliente.id != last.cliente.id){
				object.find('.nombre')
					.attr('id', data.cliente.id)
					.find('.text-value').html(data.cliente.nombre)
		     } 
			if (data.fecha != last.fecha || data.hora != last.hora){
					let idCell=  generateId.encode( data.agenda , data.fecha , data.hora ),
						lastCell = generateId.encode( last.agenda , last.fecha , last.hora ),
						clon = object.clone()
					
					object.remove()
					clon.appendTo('#'+idCell)
					main.lbl.style()
				}
			if (data.obs != last.obs) object.find('#obs').val(data.obs)
				
			},
		container : function (data, htmlSer) {
			var html_icono_desplegar = (data.servicios.length <= data.tiempoServicios) 
				? "<span class ='icon-angle-down fnExtend' ></span>"
				:""
			var claseNotas  = ($.isEmpty(data.nota))?'':'show'
			var html = "\
				<div id='idCita_"+data.idCita+"' lastmod='"+data.lastMod+"'	 idcita="+data.idCita+" class='lbl row_"+main.unidadTiempo(data.tiempoServicios)+"' tiempo='"+data.tiempoServicios+"'> \
					<div id ='"+data.idUsuario+"' class='nombre'> \
						<span class ='icon-user-1'></span> \
						<span>"+data.nombre+"</span> \
					</div> \
					<div class='iconos'>"+ 
					html_icono_desplegar
					+"<div class='icons_crud'>\
							<span class ='fnEdit icon-pencil-1'></span>  \
							<span class ='fnDel icon-trash'></span>  \
						</div>\
						<span class ='fnMove icon-move '></span>  \
					</div> \
					<div class='servicios "+main.unidadTiempo(data.tiempoServicios)+"'>"+htmlSer+"</div> \
					<div class='note "+ claseNotas + "'> \
						<span class='icon-note'></span> \
						<span class='text_note'>"+data.nota+"</span> \
					</div> \
				</div> \
			"

			return html 					
		 }, 
		service : function (data) {
				var html = "\
					<div class='servicio'>\
						<span class ='icon-angle-right'></span>\
						<span class='codigo' des_codigo='"+data.descripcion+"' \
						id_codigo = '"+data.id+"' tiempo = '"+data.tiempo+"'>"+data.codigo+"</span>\
					</div>\
				"

				return html
				
			}, 
		style : function() {
				var self = main , lbl = main.lbl 
					
				lbl.draggable()
				
				$('.lbl')
					.css('z-index',2)
					.width(main.lbl.widht)
				lbl.color()	

			}, 
		delete: function(idCita, noMens){

				var $this = $('#idCita_'+idCita)
				if (noMens || confirm('Desea eliminar la cita con id: ' + idCita + ' ?')){
					$this.hide('explode',function(){$this.remove()})
					main.lbl.color()
					return true 
				} else 	return false 

			},
		color: function(callback){	
			var $sec = $("#main") , 
				dias= $sec.find('.dia'),
				agendas = ($sec.find('thead th').length) - 1, 
				colorPares = new Array(), 
				colorImpares = new Array(), 
				$lstClientes = $('#lstClientes')

			dias.each(function(){
			
				$(this)
					.find('color1').removeClass('color1').end()
					.find('color2').removeClass('color2').end()
					.find('color3').removeClass('color3').end()
					.find('color-red').removeClass('color-red')
				


					let idCita = 0;
					$(this).find('.lbl')
						.each(function(){
							let a = $(this).parent().attr('agenda'), 
								id = $(this).find('.nombre').attr('id'), 
								colorCliente = $lstClientes.find('option[data-id="'+id+'"]').data('color')							
							if (!$.isEmpty(colorCliente)){
								$(this).css('background-color',colorCliente)
							} else {
								if(a%2==0){
									if(colorPares[a] == 'undefined') colorPares[a] = 'color1'
									color = colorPares[a]
									colorPares[a] = colorPares[a] == 'color1'?'color2':'color1'
								}else{
									if(colorImpares[a] == 'undefined') colorImpares[a] = 'color2'
									color = colorImpares[a]
									colorImpares[a] = colorImpares[a] == 'color1'?'color2':'color1'
								}
								$(this)
									.removeClass('color1 color2 color3 color-admin')
									.addClass(color);
							}					
							//Si hay igual de servicios que lineas escondo el nombre 
							var tiempo = Math.ceil($(this).attr('tiempo')/15), 
								servicios=$(this).find('.servicio').length
							if (tiempo<=servicios){
								$(this).find('.nombre').hide()
								$(this).find()
							} 
							
						})
				
			})
			typeof callback == "function" && callback();
		 },
		draggable : function(){
			$('.lbl').each(function(){
				var dia = $(this).parents('.dia')
				var limit = dia.attr('id')
				var c = dia.find('#05201709111200')
				var posi = c.position()
								
				$(this).draggable( {
					//containment: "#"+limit , 
					disabled : false, 
					opacity : 0.50 , 
					zIndex: 100 ,
					revert: function(ob){
						if (ob == false){
							$('.ui-draggable-dragging').remove()
							$('#'+main.lbl.idLastCelda)
								.html(main.lbl.clone)
							main.lbl.draggable()
							return true
						}
						}, 
					revertDuration: 500,
					handle :$(this).find('.fnMove'), 
					stop : function(e, ui){
						},
					start : function ( e, ui) {
						main.lbl.clone = $(this).clone().removeClass('ui-draggable-dragging').css('opacity',0.8)
						main.lbl.idLastCelda = $(this).parents('.celda').attr('id')
						},
				}) 
			})
		 },
		droppable : function () {
			$( ".celda" ).droppable({
					accept : ".lbl",
					classes: {"ui-droppable-hover": "ui-state-hover"}, 
					drop: function( event, ui ) {

							var posi = $(this).position()
							var drag  = ui.draggable
							var css_margin = 1 ;
							var idCita = drag.attr('idcita')
							var idCelda = $(this).attr('id')

							if (idCelda != main.lbl.idLastCelda && confirm('Desea modificar la cita ')) {
								drag.animate({ 'top': posi.top + css_margin + 'px', 'left': posi.left + css_margin + 'px'}, 200, function(){
									//end of animation.. if you want to add some code here
								})
								$(this)
								.find('.fnCogerCita').remove().end()
								.append(main.lbl.clone)
								
								main.lbl.style()
								
								$('#' + main.lbl.idLastCelda)
								.append('<i class="icon-plus fnCogerCita"></i>')
								.find('.lbl').remove()
																
								main.edit(idCita , idCelda)
								
							} else {
								
								drag.draggable("option", "revert", true)	
								$('.ui-draggable-dragging').remove()
								$('#'+main.lbl.idLastCelda)
									.append(main.lbl.clone)
								main.lbl.draggable()
								
							}	
							main.lbl.clone = null
					},				
				})

			},	
		resize : function($this){
			var tamanyoNota = Math.ceil($this.find('.text_note').height()/$('.celda:visible').first().height())

			var unidadTiempo = Math.ceil($this.attr('tiempo')/15), 
				totalServicios = $this.find('.servicio').length + tamanyoNota + 1
				//if ($this.hasClass('row_2')&&$this.find('.codigo').length==1) return false
			if(unidadTiempo < totalServicios)
				if ($this.hasClass('initial')){
					$this
						.removeClass('initial') 
						.find('.nombre').hide({duration:500}).end()
						.find('.icon-angle-up')
							.removeClass('icon-angle-up parpadear')
							.addClass('icon-angle-down')
						.end()
						.removeClassPrefix('row_', {duration:500})
						.addClass('row_' + unidadTiempo, {duration:500})

					if ($this.hasClass('with_6'))
						$this.find('.icons_crud').hide()
				} else {

					$this	
						.find('.nombre').show({duration:500}).end()
						.find('.icon-angle-down')
							.removeClass('icon-angle-down')
							.addClass('icon-angle-up parpadear')
						.end()
						.removeClassPrefix('row_', {duration:500})
						.addClass('initial row_'+totalServicios, {duration:500}) 	

					if ($this.hasClass('with_6'))
						$this.find('.icons_crud').css('display','inline-block')
				
				}
			}
		 }
},
menu = {
	nav: {
		open: (estado=null)=>{
			 
			if(!$.isEmpty(estado)){
				estado= estado>2?0:estado
				localStorage.setItem("menuOpen",estado)

			} else {
		
				if($.isEmpty(localStorage.getItem("menuOpen"))){
			
					localStorage.setItem("menuOpen",1)
				}
				
				return parseInt(localStorage.getItem("menuOpen"))				
			}
			
		 },
		estado: (estado, callback)=>{
			//Inicia el 
			if($.isEmpty(estado) && estado != 0){
				estado = 1
				menu.nav.open(1)
			}

			// si es un movil solo tiene dos estados 
			if(Device.isCel() && estado > 1 ) {
					localStorage.setItem("menuOpen",0)
				estado = 0			
			}
		
			switch (parseInt(estado)){
				case 1: 				
					$('#mySidenav').width(50)
						.find('a').width(20).end()
						.find('.caption').hide()							
					$('#login')
						.width((main.login.ancho - 25))
						.animate({'left':25}, callback)
					localStorage.setItem("menuOpen",1)
				break
				case 2: 
					$('#mySidenav').width(150)
						.find('a').width(120).end()
						.find('.caption').show()

					$('#login')
						.width((main.login.ancho - '90'))
						.animate({'left':90}, callback)
					localStorage.setItem("menuOpen",2)
			
				break
				default:
					$('#mySidenav').width(0)
					$('#login')
						.removeAttr( 'style' )	
					callback
					localStorage.setItem("menuOpen",0)
				
			}
		 }
	 }, 
	status: function (capa){
		var add = $('#btnAdd'),
			reset 	= $('#btnReset'),
			search 	= $('#btnSearch'),
			save 	= $('#btnSave'),
			show  	= $('#btnShow'),
			edit  	= $('#btnEdit'),
			options = $('#btnOptions'),
			del  	= $('#btnDel'),
			calendar = $('.contenedor-datepicker'), 
			df 		= {
				options : true
			}
		options.find('li').addClass('disabled')

		menu.disabled(add,del,reset,search,save,show,edit,options,calendar)

		switch(capa) {
			case 'main':
				menu.enabled(show,calendar)
				break;
			case 'crearCita':
				menu.enabled(search,calendar)
				break;
			case 'usuarios':
				menu.enabled(add,search)
				break;
			case 'servicios':
				 menu.enabled(add,search)
				 break;
			case 'config':
				menu.enabled(save)
				 break;
			case 'familias':
				menu.enabled(add)
				break;
			case 'horarios':
				menu.enabled(add,save,del)
				break;
			case 'agendas':
				menu.enabled(save,add)
				break;
			case 'festivos':
				menu.enabled( add ) ;
				break;
			case 'general':
				menu.enabled(save) ;
				break ;
			case 'estilos':
				menu.enabled(save) ;
				break;
			case 'notas':
				menu.enabled(add)
				break
			case 'history':
				menu.enabled(calendar)
				df.options = false
				options.find('#showByTime').removeClass('disabled')
				break
		 }
		if (df.options) options.find('#rowsHiddens').removeClass('disabled')
		$('#navbar').resize()
	 },
	save:function (){
		var _loadShow = function (){
			$('#btnSave')
			.find('.animate').css('display','inherit')
			.siblings("[class*='lnr-']").hide().end()
		 }()
		var _loadHide = function (){
			$('#btnSave')
				.find('.animate').hide().end()
				.siblings("[class*='lnr-']").show()
		 }
		switch($('.capasPrincipales:visible').attr('id')) {
			case 'config':
				config.guardar(_loadHide)
				break;
			case 'horarios':
				horario.guardar(_loadHide);
				break;
			case 'agendas':
				agendas.guardar(_loadHide);
				break;
			case 'festivos':
				festivo.guardar(_loadHide);
				break;
			case 'general':
				general.guardar(_loadHide);
				break;
			case 'estilos':
				estilos.save(_loadHide);
				break;
			case 'notas':
				notas.save(_loadHide)
				break;
		 }
	 },
	show: function (){
		switch($('.capasPrincipales:visible').attr('id')) {
			case 'main':
				main.inactivas.click()
			break;
		}
	 },
	edit: function (){
		switch($('.capasPrincipales:visible').attr('id')) {
			case '':
			break;
		 }
 	 },
	add: function (){
		switch($('.capasPrincipales:visible').attr('id')) {
			case 'agendas':
				agendas.add();
				break;
			case 'usuarios':
				usuarios.dialog(-1);
				break;
			case 'servicios':
				 servicios.dialog(-1);
				break;
			case 'familias':
				familias.dialog(-1);
				 break;
			case 'horarios':
				horario.nuevo()
				break
			case 'festivos' :
				festivo.dialog(-1) 
				break
			case 'notas' :
				notas.dialog(-1) 
				break
		 }
	 },
	del: function (){
		switch($('.capasPrincipales:visible').attr('id')) {
			case 'horarios':
				horario.del();
				break;
		}
	 },
	reset:function(){
		switch($('.capasPrincipales:visible').attr('id')) {
			case 'main':
				main.refresh('main' , function () {
					$('#btnReset .animate').hide()
				}) 
			break;
		}
	 },
	disabled:function (){
		for(let i = 0; i < arguments.length; i++)
			arguments[i].hide(100)
	 },
	enabled: function (){
		for(let i = 0; i < arguments.length; i++)
			arguments[i].show(100)
	 },
	load:function (){

		menu.exit()

	 },
	exit: function (){
		$('#txtBuscar').val("")
			.parent().hide('slide',{direction:'right'})

	 },
	options : function($this){
		if ($('#btnOptions #chckOpUsersDel').is(':checked'))
			$('.ocultar_baja').removeClass('ocultar_baja').addClass('mostrar_baja') ;
		else
			$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja') ;

		servicios.init();	
	 },
	buscar :function(txt, sec, col){
		$sec = $("#"+sec)
		$encontrados =txt.match(/^@$/)
			?$sec.find('td.email:contains('+txt+')')
			:$sec.find('td.busqueda:contains('+txt+')')
		if($encontrados.length){
			$sec.find("tbody tr").hide().end()
			$encontrados.parents('tr').show()
		} else{
			$sec.find("tbody tr").hide()
		}
		colorear_filas($('.colorear-filas:visible'))
	 }
},
notas = {
	nombreDlg : 'dlgNotas',
	dir : 'right',
	init : function(){
		cargarDatepicker();
	 },
	load : function(){
		$('#tile_seccion').text('Notas')
	 },
	dialog:function(id=-1){
		var fnLoad = function () {
		var  $dlg = $('#'+notas.nombreDlg)
			$dlg.find("#id").val(id)

			if (id==-1){ 
				//NUEVO....
				
				$dlg
					.find('#fecha').val(Fecha.sql).end()
					.find('#hora').val('00:00').end()
					.find('#descripcion').val('Escribe una nota').end()
					.find('h1').html('Nuevo...')
		
			}else{ 
				//EDITANDO..
				
				var $row = $("#notas #trNotas"+id),	
					fecha = $row.find(".idFecha").text(),
					hora = $row.find(".idHora").text(),
					des = $row.find(".idDescripcion").text()

				$dlg
					.find('#fecha').val(Fecha.sql(fecha.trim())).end()
					.find('#hora').val(hora.trim()).end()
					.find('#descripcion').val(des)				
			}		
		}
		
		dialog.open(
			notas.nombreDlg,
			notas.save,
			()=>notas.delete($('#dlgNotas #id').attr('value')),
			fnLoad
		)

	 },
	save : function(callback){

		var  $dlg = $('#dlgNotas'), 
		 data =  {
			id : $dlg.find('#id').val(), 
			nota : $dlg.find('#descripcion').val(),
			fecha : $dlg.find('#fecha').val() ,
			hora : $dlg.find('#hora').val(), 
			controller : 'notas', 
			action : SAVE
		}

		$.post(INDEX, data,function (r, textStatus, jqXHR) {
			if (r.success) {
				dialog.close(this.nombreDlg)

				data.id = (data.id>-1) ?data.id:r.id; 
				notas.crear.linea(data)

				notify.success('Su nota ha sido guardada')
			} else{
				notify.error('No se ha podido guardar la nota')
				echo (r)
			} 

			typeof callback == "function" && callback();
		 },JSON)
		
	 }, 
	delete : function(id,callback){

		let data = {
			controller : 'notas' , 
			action : DEL , 
			id : id
		}
		$.post(INDEX, data,
			function (r, textStatus, jqXHR) {
				if (r.success) {
					$("#notas #trNotas"+data.id).remove()
					dialog.close('dlgNotas')
				} else {
					notify.error('No se ha podido eliminar la nota')
					echo (r)
				} 
				typeof callback == "function" && callback();
			},
			JSON
		)
	 },
	sync : function(fecha){
	    var $obj = $('#notas table tbody')
		$obj.find('tr').addClass('ocultar').removeClass('mostrar')

		let data = {
			controller : 'notas' , 
			action : GET , 
			fecha : fecha
		}
		$('div#mySidenav a#menu5.hay-nota').removeClass('hay-nota')
		$.post(INDEX, data, function (r, textStatus, jqXHR) {
			
			if(r.success){
				$('div#mySidenav a#menu5').addClass('hay-nota')
				for (let i = 0, datos= r.data,  len = datos.length; i < len; i++) {
	
					notas.crear.linea(datos[i])							
				}		
			} else {
				$('#menu5').removeClass('c4')
			}
			return r.success
		},JSON)
		
		$obj.find('.'+Fecha.id).removeClass('ocultar').addClass('mostrar')	

	 },
	crear : {
		linea : function (d){
			let mostrar =  (d.fecha == Fecha.general)?'mostrar':'ocultar';
			$('#notas table tbody')
				.find('#trNotas'+d.id).remove().end()
				.find('tr.template').clone()
				.removeClass().addClass(Fecha.number(d.fecha) + " " + mostrar)
				.attr('id','trNotas'+d.id)
				.find('a').attr('value',d.id)
				.end().find('.idid').text(d.id)
				.end().find('.idFecha').text(Fecha.print(d.fecha))
				.end().find('.idHora').text(d.hora)
				.end().find('.idDescripcion').text(d.nota)
				.end().appendTo('#notas tbody')
		 },
	 }, 
}, 
Device = {
	cel: false, 
	init : function(){
		this.cel = ($(window).width()<=375)
	}, 
	isCel: function(val = false){
		if($.isEmpty(val)){
			return this.cel
		} else  {
			this.cel = val
		}
	}
}
$(function(){
	main.login.ancho = $('#login').width()
	main.inactivas.change(localStorage.getItem("showRows"))
	main.inactivas.comprobar()

	//Construyo la "clase" device para saber el dispositivo usado
 	Device.init()

	cargarDatepicker()
	colorearMenuDiasSemana()

	menu.nav.estado(localStorage.getItem("menuOpen"), function(){
		main.lbl.widht = $('.celda:visible').first().width() - 2 
		main.login.ancho = $('#login').width()
	})

	$('body')
		.on('click',".idDateAction",function(){
		
		if(!$(this).data('disabled')) {
			sincronizar($(this).data('action'));
		}
		  })
		.on('click','#boton-menu', function(){
			var estado = parseInt(localStorage.getItem("menuOpen"))+1

			menu.nav.open(estado)
			menu.nav.estado(estado)

		})
	$('.tabcontrol').tabcontrol()	

	$('html')
		.on('click','.close',function(e){dialog.close()})
		.on('change','input',function(){$(this).removeClass('input-error')})
		.on('change','#lstSerSelect',function(){
			var id = $(this).val();
			// servicios.mostrar(id);
			$('#lstSerSelect').each(function(){
				$(this).find('option[value='+id+']').attr('selected','selected');
			})
		 })
	
	$('#btnContacto').click(function(){
		var menu = $('#mnuContacto')
		if(menu.is(':visible'))
			menu.hide('slide',{ direction: 'right' })
		else
			menu.show('slide',{ direction: 'right' })
	 })

	$('#frmContact button')
		.click(function(event){
			
			event.preventDefault()
			var data = $("#frmContact").serializeArray()
			data.push({name : 'controller' , value : 'contacto'})

			$.post(INDEX,data,function(r){
				if(r.success)
					notify.success('Email mandado con éxito') 
				else 
					notify.error('No se pudo mandar el email!! <br> Compruebe que estan todos los datos')
				
				btn.load.hide()
			},'json')
		})

	$(".login")
		.on('focusout','[data-max-leght]',function(){
			var $this = $("[data-max-leght]");
			if($this.val().length>$this.data("max-leght")){
				$this.removeClass("valid");
				$this.addClass("invalid");
			}else{
				$this.removeClass("invalid");
				$this.addClass("valid");
			}
		});

	$('#main')
		.on('click','.lbl',function(e){
			main.z_index =(main.z_index<=2)?3:2; 
			$(this).css({'z-index': main.z_index })	
			main.lbl.resize($(this))
		 })
		.on('click','.fnCogerCita',function(){
			localStorage.setItem('agenda', $(this).parent().attr('agenda'))
			localStorage.setItem('hora', $(this).parents('tr').data('hour'))

			mostrarCapa('crearCita')
		})
		.on('click','#mainLstDiasSemana a',function(){
			var diaA =  parseInt(Fecha.diaSemana(Fecha.general));
			var diaB = parseInt($(this).data('value'));
			sincronizar(diaB-diaA);
		 })
		.on('change','#lstDiasSemana',function(){
			var diaA =  parseInt(Fecha.diaSemana(Fecha.general));
			var diaB = parseInt($(this).val());
			sincronizar(diaB-diaA);
		 })
		.on('click','.icon-attention',function(e){
			main.citasSup($(this));
			e.stopPropagation()
	    	})
		.on('click','.fnEdit', function(e){
			e.stopPropagation() 
			main.edit($(this).parents('.lbl').attr('idcita'))
		 })
		.on('click','.cita',function(e){
			$(this).parent()
				.find('.note')
					.addClass('show')
					.find('input')
						.focus();

		 })
		.on('click','.lbl .fnDel',function(e){
			$( ".selector" ).draggable( "option", "disabled", true );
			e.stopPropagation();
			main.del($(this).parents('.lbl').attr('idcita'))
		 })
		.on('change','#selectTablasEncabezado',function(){
			main.responsive($(this))
		 })
		.on('change','.nombreagenda',function(){

			var data = {
				id : $(this).data('agenda'), 
				nombre : $(this).val(),
				controller: 'agendas',
			 	action:'saveName'
			}
			 $.post(INDEX,data,function(r){
				 
			 },JSON)

		 })
		.find('.cuerpo')
			.on("swipeleft",function(){sincronizar(1)})
			.on("swiperight",function(){sincronizar(-1)})

	$('#navbar')
		.on('click','#btnShow',menu.show)
		.on('click','#btnEdit',menu.edit)
		.on('click','#btnSearch',function(){
			if ($('#txtBuscar').is(':hidden')){
				$('#txtBuscar')
					.parent().show('slide',{direction:'right'}).end()
					.focus()
			}else{
				menu.load();
			}
		 })
		.on('change','#txtBuscar',function(){
			if($('#txtBuscar').val()!=""){
				menu.buscar(
					$('#txtBuscar').val(),
					$('.capasPrincipales:visible').attr('id')
				)
			}
		})
		.on('click','#btnReset',function(){
			if($('#usuarios').is(':visible')) usuarios.select('A');
		 })
		.on('click','#btnSave',menu.save)
		.on('keyup','#txtBuscar',function(event){
			if(event.which==13)menu.load()
			if(event.which==27){
				event.stopPropagation
				menu.exit();
			}
		 })
		.on('click','#btnAdd',menu.add)
		.on('click','#btnDel',menu.del)
		.on('click','#btnReset',menu.reset)
		.on('click','#btnOptions #chckOpUsersDel',menu.options)
		.find('#showByTime')
			.on('click','input', function(){
					$(this).prop('checked',true)
					historial.get($(this).val())
				}
			).end()

	$('#mySidenav')
		.find('[name="menu[]"]').parent().click(function(){
			if(Device.isCel()) {
				menu.nav.open(0)	
				menu.nav.estado(0)
			}

			$('.app-bar-pullmenu ').hide('blind');
			$('#mySidenav .selected').removeClass('selected')
			$(this).find('a').addClass('selected')

			var capa = $(this).find('a').data('capa') ;
			if (capa == 'main'){
				mostrarCapa('main' ,  true ) 
			}else{
				mostrarCapa($(this).find('a').data('capa'));
			}
		 })
		 
	$('#notas')
		.on( "click", ".fnEdit", function(e){notas.dialog($(this).attr('value'))})

	$('#tile_seccion').text('Reserva de citas')
	main.lbl.load()
	menu.status('main')
})