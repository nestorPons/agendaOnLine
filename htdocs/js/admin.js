
if ($('#navbar').is(':hidden')) $('#navbar').show('blind')
var _hora = 0; 
//Funcion para menu responsive 
//No se puede sobreesctribir la funcion en jquery asi que tengo que hacer una funcion suelta
function menuEsMovil(tab){
	$('.esMovil .dia [agenda]').each(function(){
		$(this).hide()
	})
	$('.esMovil .dia').find('[agenda="'+tab.attr('agenda')+'"]').fadeIn()

	return true
 }
function sincronizar( dias, date , callback ){
	var fecha = date||Fecha.general ,
		datepicker = $('.datepicker')

	if (dias)
		fecha =  Fecha.calcular(dias, fecha);
	else
		dias = 0;
	
	Fecha.general = Fecha.sql(fecha);
	Fecha.id = Fecha.number(Fecha.general);


	main.sincronizar(dias)
	notas.sync()
	if ($('#crearCita').find('div').length )
		crearCita.horas.sincronizar()

	colorearMenuDiasSemana();
	
	var diaFestivo = $.inArray(Fecha.md(Fecha.general),FESTIVOS)!=-1;
	$.each(datepicker, function( index , me ){
		(diaFestivo)?$(this).addClass('c-red'):$(this).removeClass('c-red')

		$(this)
			.val(Fecha.print(fecha))
			.datepicker("setDate",Fecha.print(fecha));
	 })

 }
function mostrarCapa(capa, callback){
	var data = { 
		controller : capa ,  
		fecha :  Fecha.sql ,
	 }
	if($('#'+capa).is(':visible')) return false;
	$('#chckOpUsersDel').prop( "checked", false ) ;
	$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja') ;

	if($('#'+capa).is(':empty') ){
		$.post(INDEX,data,function(html){

			$('#'+capa).html(html).promise().done(__INIT__);
			function __INIT__ (){
				capa=='crearCita' && crearCita.init()
				capa=='servicios' && servicios.init()
				capa=='usuarios' && usuarios.init()
				capa=='estilos' && estilos.init()
				capa=='notas' && notas.init()
			}

		},'html')
	 }
	
	if($('#config').is(':visible')&&config.change) config.guardar();
	if($('#agendas').is(':visible')&&agendas.change) agendas.guardar();
	if($('#crearCita').is(':visible')) crearCita.reset();

	$('.capasPrincipales').hide()
	$('#'+capa).fadeIn()

	menu.status(capa)

	if(capa=='main') $('#'+Fecha.id).show()

	btn.load.reset()

	$('html,body').animate({scrollTop:0}, 500)
	$('#navbar')
		.find('.selected').removeClass('selected').end()
		.find('[data-capa="'+capa+'"]').addClass('selected')
	typeof callback == "function" && callback()
	}
function sliderConfigBorder ( value, slider ) {
	estilos.test( value ) 
 }	
var 
servicios = {
	controller : 'servicios',
	init : function () {

		var clase = $('.menuServicios a').not('.ocultar_baja').attr('id')  ; 
		if (!$.isEmpty( clase )){
			clase_id = clase.replace(/\D/g,'')
			servicios.mostrar(clase_id) ;
		 }
		
		},
	buscar: function(){
		$('#servicios .capaServicios').fadeIn();
		$("#servicios tr").fadeOut();
		$("#servicios .encabezado:first").fadeIn();
		var txt = normalize($('#txtBuscar').val());
		$("[name*='"+txt+"']").not('.ocultar_baja').fadeIn();
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
	dialog:function(id){
		var fnLoad = function (isNew) {
			var dlg = $('#dlgServicios')

			if (dlg.find('#lstFamilias select').length==0){
				var $lstFam = 
					$('#servicios .menuServicios #lstSerSelect')
						.clone(true,true)
						.removeClass('responsiveDesing_show')
						.appendTo('#dlgServicios #lstFamilias');
			}
			dlg.find("#id").val(id);
			
			if (id!=-1){ 
				//EDITANDO...
				var row = $("#servicios #rowServicios"+id),	
					cod = row.find("[name='cod']").text(),
					des = row.find("[name='des']").text(),
					time = row.find("[name='time']").text(),
					price = row.find("[name='price']").data("value"),
					fam = row.attr('familia')

				dlg
					.find('#codigo').val(cod).end()
					.find('#descripcion').val(des).end()
					.find('#tiempo').val(parseInt(time)).end()
					.find('#precio').val(price).end()
					.find('#familia').val(fam).end()
					.find('#eliminar').val('Eliminar').end()
					.find('h1').html('Editando...')

			}else{ 
				//NUEVO....
				var idCapa = $('#servicios .c3').attr('id');
				dlg
					.find('#id').val(-1).end()
					.find('#codigo').val($('#servicios #buscarTxt').val()).end()
					.find('#familia').val(idCapa).end()
					.find('#btnEliminar').val('Cancelar').end()
					.find('h1').html('Nuevo...')
			}
			
			if ($('#servicios #rowServicios'+ id ).hasClass('mostrar_baja')) {
				dlg.find('.aceptar').html('Restaurar')
			}
		}

		dialog.open('dlgServicios',servicios.guardar,servicios.eliminar,fnLoad)
		},
	guardar: function (){
		var _fnOk = function (rsp , isNew){
				if (rsp.success) {
	
					isNew ?  servicios.crear(rsp)  : servicios.actualizar(rsp) 
	
					servicios.mostrar(rsp.idFamilia)
					
					dialog.close('dlgServicios')
					
				}else{ 
					notify.error('Codigo de servicio ocupado </br> Seleccione otro codigo distinto.', 'CODIGO OCUPADO') ;
				}
				$("#servicios #rowServicios"+id).fadeTo("slow", 1);
				btn.load.hide();
			}
		if(servicios.validate.form()){
			var id= $('#frmEditarServicios #id').val().replace(/\D/g,' ').trim()

			servicios.sendAjax(SAVE , _fnOk)

		  }else{
			btn.load.hide()
		  }		
		 },
	eliminar: function() {

		var id= $('#dlgServicios #id').val().trim(), 
			_fnOk = function (r) {

				if (r.success == true){

					var baja  = $('#chckOpUsersDel').is(':checked')? 'mostrar_baja' : 'ocultar_baja'

					$("#rowServicios"+id).each(function(){
						$(this).addClass(baja) 
					})
		
				}else{

					$("servicios #rowServicios"+id).fadeTo("slow", 1)
					notify.error(r.success) 
				}

				dialog.close('dlgServicios')
			}

		if (id!=-1){
			if (confirm ("Deseas eliminar el servicio "+id+", " + $('#dlgServicios #codigo').val() + "?")) 
				servicios.sendAjax(DEL , _fnOk)

		}else{
			dialog.close('dlgServicios');
		}
		},
	actualizar: function(datos){

		$('#servicios #rowServicios'+datos.id)
			.css('class','fam'+datos.idFamilia)
			.removeClass('mostrar_baja , ocultar_baja') 
			.attr('name',normalize(datos.codigo))
			.attr('familia',datos.idFamilia)
			.removeAttr('class').addClass('fam'+datos.idFamilia)
			.attr('value',datos.id)
			.find(' td:nth-child(1)').attr('value',datos.id).end()
			.find(' td:nth-child(2)')
				.html(datos.codigo)
				.attr('id', data.id)
			.end()
			.find(' td:nth-child(3)').html(datos.descripcion).end()
			.find(' td:nth-child(4)').html(datos.tiempo).end()
			.find(' td:nth-child(5)').data('value' , datos.precio).end()

		

		$('#crearCita #rowServicios'+datos.id)
			.removeClass('mostrar_baja , ocultar_baja') 
			.css('class','fam'+datos.idFamilia)
			.find('label')
				.attr('for', datos.codigo)
				.text(datos.descripcion + ' (' + datos.tiempo +'min.)')
			.end()
			.find(':checkbox').attr({
				id : datos.codigo , 
				value : datos.id , 
				'data-time' : datos.tiempo , 
				'data-familia' : datos.idFamilia ,
			})

		
		},
	crear: function(data){
					//NUEVO
		var mostrar = (data.mostrar==1)?'checked':'';

		$('#servicios').find('table tbody').append('\
			<tr id="rowServicios'+data.id+'">\
				<td class="ico"><a name="editar[]" class="icon-edit x6"></a></td>\
				<td name="cod" class="aling-left cod"></td>\
				<td name="des" class="nom"></td>\
				<td name="time" class="ico"></td>\
				<td name="price" class="hidden"></td>\
			</tr>\
		')

		$('#crearCita').find('.contenedorServicios tbody').append('\
			<tr id="rowServicios'+data.id+'">\
				<td>\
					<label>\
						<input type="checkbox" name="servicios[]" class="idServicios">\
					</label>\
				</td>\
			</tr>\
		')

		servicios.actualizar(data)
	
		},
	sendAjax: function(action , callback){
		var dlg = $('#dlgServicios') , id = dlg.find('#id').val() ,row = dlg.find("#rowServicios"+id)
		var	data = $("#frmEditarServicios").serializeArray()			
			data.push({name : 'baja' , value : 0})
			data.push({name : 'controller' , value : servicios.controller})
			data.push({name : 'action' , value : true})
		if (action == DEL)
			data.push({name : 'baja' , value : 1})

		var isNew = id==-1

		id!=-1 && row.fadeTo("slow", 0.30)

		$.ajax({
			url: INDEX,
			type: "POST",
			dataType: "json",
			data: data,
		})
		.done(function(rsp){
			typeof callback == "function" && callback(rsp ,isNew)
		})
		.fail(function( jqXHR, textStatus, errorThrown ) { 
			echo (jqXHR, textStatus,  errorThrown) 
		 })
		},
	validate : {
		form : function () {  
			var nombre = $('#dlgServicios #codigo').val(); 

			if ($.isEmpty(nombre)){
				notify.error('El campo del codigo no puede estar vacio.','ERROR CAMPO VACIO!')
				return false ;
			}else {
				return true ;
			}
		 }
	 }
 },
main ={	
	xhr : new Object(), 
	section : $("#main") , 
	body : $('#main .cuerpo') ,
	z_index : 2 ,
	data : new Object(), 
	arrSer : new Array(), 
	last : new Object(),
	idsControl : new Object(),
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
				tiempoTotal : 0
			 }
			lbl.find('.codigo').each(function(i,o){
				var id =$(this).attr('id_codigo') , 
					codigo = $(this).html() , 
					descripcion = $(this).attr('des_codigo') ,
					tiempo = $(this).attr('tiempo')

				main.data[idCita].servicios.push({id ,  codigo ,  descripcion , tiempo})
				main.arrSer.push({id ,  codigo ,  descripcion , tiempo}) 
				main.data[idCita].tiempoTotal += parseInt(tiempo)	
			 })
	 	 }
	 }, 
	sincronizar: function (dir,callback){
		
		var self = main , section = main.section , body = main.body

		if (!section.find('#'+Fecha.id).length) self.crearDias(callback)

		//no lo meto en fin de carga para avanzar mas rapido
		if (Fecha.id != section.find('.dia.activa').attr('id')) {
			var dir= dir||0,
				ent = (dir>0||dir=='right')?'right':'left',
				sal = (ent=='right')?'left':'right'
	
			body.hide("slide", { direction: sal }, 750,function(){
				$('.dia.activa').removeClass('activa')
				section.find('#'+ Fecha.id).addClass('activa')
				body.show("slide", { direction: ent }, 750,);
			})
		} 	
			 main.check()

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

					data.uTiempo = Math.ceil(tt / 15)  
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

		$.each(dias,function(){
			ids.push($(this).attr('id'));
		})
		if(crearCita.xhr && crearCita.xhr.readyState != 4) xhr.abort()
        
		crearCita.xhr = $.ajax({
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
			main.deleteDuplicate() 
			main.lbl.droppable()
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
	deleteDuplicate: function(){
		var section = $('#main')
		section.find('.dia').each(function( i , self ){
			var days =  section.find(' #' + self.id ) 
			var num = days.length
			if (num > 1)  $('#main #'+ self.id).first().remove()
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
		var lbl = $('#idCita_'+idCita+'.lbl')  
		main.set.data(idCita)

		main.last = {
			idCita : main.data[idCita].idCita,
			agenda : main.data[idCita].agenda,
			tiempoTotal : main.data[idCita].tiempoTotal , 
			hora : main.data[idCita].hora , 
			fecha : main.data[idCita].fecha, 
			cliente : {
				id : main.data[idCita].cliente.id, 
				nombre : main.data[idCita].cliente.nombre
			},
			obs : main.data[idCita].obs 
		}
	
		var _addServiceToLbl = function (callback){
			var arrSer = main.data[idCita].servicios
			var lblSer = lbl.find('.servicios') , html = ''
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

			if (main.last.tiempoTotal != main.data[idCita].tiempoTotal){

				var t = Math.ceil(main.data[idCita].tiempoTotal / 15) 
				var l = Math.ceil(main.last.tiempoTotal / 15) 
				lbl.removeClass('row_'+l).addClass('row_'+t)
			}
			typeof callback == "function" && callback();
		 }
		var _delRow = function(div){
			var cod = div.find('.codigo')
			var idCod = cod.attr('id_codigo')

			main.data[idCita].tiempoTotal -= cod.attr('tiempo')

			var arrSer = main.data[idCita].servicios
			var index = arrSer.indexOf(idCod)

			main.data[idCita].servicios.splice(index, 1)
			div.fadeOut('fast').remove()

		 }
		var _addRow = function (id , codigo , descripcion ,tiempo ){

			$('#dlgEditCita .template')
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

		 }
		var _eventAddService = function () {
			$('#dlgEditCita').on('change','#lstServ',function(){
				var select  = $(this).find(':selected')
				var id = select.val() , codigo = select.attr('codigo') , descripcion = select.text() , tiempo = select.attr('tiempo')

				main.data[idCita].servicios.push({id ,  codigo ,  descripcion , tiempo})
				main.data[idCita].tiempoTotal += parseInt(tiempo)	
				_addRow (id ,  codigo ,  descripcion , tiempo)

				$(this).val('')
			})
		 }
		var _save = function () {

			var dlg = $('#dlgEditCita') , duration = 0 , arrIdSer = new Array() ,data = new Array()

			dlg.find('input').each(function(i,v){
				data[$(this).attr('id')] = $(this).val()
			})

			if (main.last.cliente.id != main.data[ main.last.idCita].cliente.id ){
			}
				let str = normalize(data['cliente'])
				let selCli = $('#lstClientes [data-name="'+str+'"]')

				main.data[idCita].cliente.id =  selCli.data('id')
				main.data[idCita].cliente.nombre =  selCli.val()

			main.data[ main.last.idCita].fecha = data['fecha']
			main.data[ main.last.idCita].hora = data['hora']
			main.data[ main.last.idCita].obs = data['obs']

			$.each(main.data[ main.last.idCita].servicios, function( i , v){

				arrIdSer.push(v.id)

			})

			var sendData = {
				action : EDIT ,
				idCita :  main.last.idCita ,
				agenda : main.data[ main.last.idCita].agenda ,
				idUsuario : main.data[ main.last.idCita].cliente.id || false ,
				fecha :  Fecha.sql(dlg.find('#fecha').val()) ,
				hora : dlg.find('#hora').val() ,
				obs :  dlg.find('#obs').val(),
				servicios : arrIdSer ,
				status : false 
			}

			main.save(sendData,function(){

				main.lbl.edit(main.data[ main.last.idCita], main.last)
				_addServiceToLbl(function(){
					dialog.close('dlgEditCita')
					if(!$.isEmpty(sendData.obs)) {
						lbl
							.find('.text_note').text(sendData.obs).end()
							.find('.note').addClass('show')
					}else{
						lbl
							.find('.text_note').text(sendData.obs).end()
							.find('.note').removeClass('show')
					}
				})


			})		
		 }

		if (!$.isEmpty(idCelda)) { 

			// se ha editado arrastrando label
			let decode = generateId.decode(idCelda)
			main.data[idCita].agenda = decode.agenda
			main.data[idCita].fecha = decode.date
			main.data[idCita].hora = decode.hour
			
			//Hay que adecuar el array servicios para mandar solo los id 
			let edata = main.data[idCita],
				len = main.data[idCita].servicios.length,
				ser = main.data[idCita].servicios
			
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
				main.del(main.data[idCita].idCita)
			 }, 
			callback = function(isNew){

				var section = $('#dlgEditCita')

				$('#dlgEditCita #codigos').html('') 

				section
					.data('idCita',idCita)
					.find('#id').val(idCita).end()
					.find('#cliente')
						.val(main.data[idCita].cliente.nombre)
						.end()
					.find('#obs')
						.val(main.data[idCita].obs)
						.end()
					.find('#fecha')
						.val(main.data[idCita].fecha)
						.end()
					.find('#hora')
						.val(main.data[idCita].hora)

				$.each(main.data[idCita].servicios , function(i,a){
					_addRow( a.id , a.codigo , a.descripcion , a.tiempo)
				})

				if (isNew) _eventAddService()
				
				lastTime = main.data[idCita].tiempoTotal

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

		if (main.lbl.delete(idCita)){
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
	inactivas:{ 
		click :	function(){
			var status = localStorage.getItem("showRows")==1?0:1
			main.inactivas.change(status)
	
		},
		change :function (std){
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
			localStorage.setItem("showRows", std)		
		}	
		},
	lbl:{
		widht :  '25' ,
		height: new Array,
		clone : new Object(), 
		idLastcelda : 0 , 
		create: function(data){
		
			//agenda,fecha,hora,idCita,idUsuario,uTiempo,nota,servicios.id
			var self = main , lbl = main.lbl ,htmlSer = '' 

			var idCelda =  generateId.encode( data.agenda , data.fecha , data.hora )
			var celda = document.getElementById(idCelda)
			$.each(data.servicios, function ( id , serv ) {
				htmlSer += lbl.service(serv)
			})

			celda.innerHTML = lbl.container(data , htmlSer)
			lbl.style()
		 },
		edit: function (data, last){
			var idCita = data.idCita , object = $('#main').find('#idCita_'+idCita)

			if (data.cliente.id != last.cliente.id){
					object.find('.nombre')
						.attr('id', main.data[idCita].cliente.id)
						.find('.text-value').html(main.data[idCita].cliente.nombre)
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
				var html = "\
					<div id='idCita_"+data.idCita+"' lastmod='"+data.lastMod+"'	 idcita="+data.idCita+" class='lbl row_"+data.uTiempo+"'> \
						<div id ='"+data.idUsuario+"' class='nombre'> \
							<span class ='icon-user-1'></span> \
							<span>"+data.nombre+"</span> \
						</div> \
						<div class='iconos aling-right'>  \
							<div class='icons_crud'>\
								<span class ='fnEdit icon-pencil-1'></span>  \
								<span class ='fnDel icon-trash'></span>  \
							</div>\
							<span class ='fnMove icon-move '></span>  \
						</div> \
						<div class='servicios "+data.uTiempo+"'>"+htmlSer+"</div> \
						<div class='note '>"+data.nota+"</div> \
					</div> \
				"

				return html 					
			}, 
		service : function (data) {

				var html = "\
					<div>\
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
					.css('z-index', 0)
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
				var dias= $('.dia');
				var agendas = ($('#main thead th').length) - 1 ;
				var idsCitas = new Array;
				var $this ;
				var color = 'color1';

				dias.each(function(){
				
					$(this)
						.find('color1').removeClass('color1').end()
						.find('color2').removeClass('color2').end()
						.find('color3').removeClass('color3').end()
						.find('color-red').removeClass('color-red')

					for(let a = 1; a <= agendas; a++){
						
						let idCita = 0;
						$(this).find('.lbl')
							.each(function(){
														
								color = color == 'color1'?'color2':'color1';
															
								$(this).removeClass('color1 color2 color3 color-admin')
								$(this).addClass(color);

							})
					}
				})
				typeof callback == "function" && callback();
			},
		draggable : function($this){
				$('.lbl').each(function(){
					var dia = $(this).parents('.dia')
					var limit = dia.attr('id')
					var c = dia.find('#05201709111200')
					var posi = c.position()
									
					$(this).draggable( {
						//containment: "#"+limit , 
						disabled : false, 
						opacity : 0.70 , 
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
							main.lbl.clone = $(this).clone().removeClass('ui-draggable-dragging').css('opacity',1)
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

							if (confirm('Desea modificar la cita ')) {
								drag.animate({ 'top': posi.top + css_margin + 'px', 'left': posi.left + css_margin + 'px'}, 200, function(){
									//end of animation.. if you want to add some code here
								})
								$(this).html(main.lbl.clone)
								
								main.lbl.style()

								$('#' + main.lbl.idLastCelda).empty()
								var idCita = drag.attr('idcita')
								var idCelda = $(this).attr('id')

								main.edit(idCita , idCelda )
								
							} else {
								//aki :: error arrastrando el dragable y cancelando
								drag.draggable("option", "revert", true)	
								$('.ui-draggable-dragging').remove()
								$('#'+main.lbl.idLastCelda)
									.html(main.lbl.clone)
								main.lbl.draggable()
								
							}	
							main.lbl.clone = null
						

					},				
				})

			},	
		resize : function($this){
				if ($this.hasClass('row_2')&&$this.find('.codigo').length==1) return false
				if ($this.hasClass('initial')){
					$this
						.removeClass('initial') 
						.animate({	height: main.lbl.height[$this.attr('id')] })
						.find('.nombre').hide().end()
					if ($this.hasClass('with_6'))
						$this.find('.icons_crud').hide()
					} 
				else
					{
					main.lbl.height[$this.attr('id')] = $this.height()

					$this
						.addClass('initial') 	
						.animate({height: $this.get(0).scrollHeight})
						.find('.nombre').show().end()
					if ($this.hasClass('with_6'))
						$this.find('.icons_crud').css('display','inline-block')
				
					}
			}
		}
	 },
menu = {
	status: function (capa){
		var add 	= $('#btnAdd'),
			reset 	= $('#btnReset'),
			search 	= $('#btnSearch'),
			save 	= $('#btnSave'),
			show  	= $('#btnShow'),
			edit  	= $('#btnEdit'),
			options = $('#btnOptions'),
			del  	= $('#btnDel'),
			df 		= {
				options : true
			}
		options.find('li').addClass('disabled')
		menu.disabled(add,reset,search,save,show,edit,options)

		switch(capa) {
			case 'main':
				menu.enabled(show,reset)
				break;
			case 'crearCita':
				break;
			case 'usuarios':
				menu.enabled(add,search,options)
				break;
			case 'servicios':
				 menu.enabled(add,search,options)
				 break;
			case 'config':
				menu.enabled(save)
				 break;
			case 'familias':
				menu.enabled(add,options)
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
				menu.enabled(options)
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
				.find('.icon-floppy').hide().end()
				.find('.icon-load').css('display','inherit')
		 }()
		var _loadHide = function (){
			$('#btnSave')
				.find('.icon-load').hide().end()
				.find('.icon-floppy').show()
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
				horario.add()
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
		/*
		$('#btnReset .icon-undo')
			.attr('class','icon-load animate-spin')
			.show()
		*/
		switch($('.capasPrincipales:visible').attr('id')) {
			case 'main':
				main.refresh('main' , function () {
					$('#btnReset .icon-undo').removeClass('icon-load animate-spin')
				}) 
			break;
		}
	 },
	disabled:function (){
		for(let i = 0; i < arguments.length; i++)
			arguments[i].addClass('disabled')
	 },
	enabled: function (){
		for(let i = 0; i < arguments.length; i++)
			arguments[i].removeClass('disabled')
	 },
	load:function (){
		if($('#txtBuscar').val()!=""){
			switch($('.capasPrincipales:visible').attr('id')) {
				case 'usuarios':
					usuarios.buscar($('#txtBuscar').val());
					break;
				case 'servicios':
					servicios.buscar();
					break;
			}
		}
		menu.exit()
	 },
	exit: function (){
			$('#txtBuscar')
			.val("")
			.parent()
				.hide('slide',{direction:'right'})
	 },
	options : function($this){
		if ($('#btnOptions #chckOpUsersDel').is(':checked'))
			$('.ocultar_baja').removeClass('ocultar_baja').addClass('mostrar_baja') ;
		else
			$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja') ;

		servicios.init();	
	 },
 },
agendas = {
	change: false ,
	add: function(){
		var data = {
			controller: 'agendas', 
			action: ADD
		 }
		$.post(INDEX,data,function(r){
			if(r)
				location.reload()
			else
				notify.error("No se ha podido crear la agenda.\n\r Consulte con el administrador")
		},JSON)
	 }, 
	del: function (id) {
		var data = {
			controller: 'agendas', 
			action: DEL, 
			id : id
		 }
		if(
		 confirm("Realmente desea borrar la agenda? \n No se podran recuperar los datos.")
		){
			$.post(INDEX,data,function(r){
				if(r)
					location.reload()
				else
					notify.error("No se ha podido eliminar la agenda.")
			},JSON)
		}
	 }, 
	guardar: function (callback){
		var data = $('#agendas #frmAg').serializeArray() ;
		data.push({name : 'controller' , value : 'agendas'})
		data.push({name : 'action' , value : SAVE})

		$.ajax({
			type: "POST",
			dataType: "json",
			data: data,
			url:INDEX
		})
		.done(function(r){
			if (r) {
				notify.success('Los cambios han sido guardados');
				agendas.change = false;
				$('#agendas #frmAg label').each(function(element) {
					var id = $(this).find('input:checkbox').val(), 
						value = $(this).find('input:text').val()
					agendas.set.name(id,value)
				}, this);
				$('#agendas #frmAg input:text').each(function(index){
					var i = index+1;
					var lblMain =$('#main .encabezado #nombreAgenda'+i)
					var lblCrearCita = $('#crearCita #frmCrearCita #lblAgenda'+i)
					var name  = $(this).val();
					if(!$.isEmpty(name)){
						lblMain.html(name)
						lblCrearCita.html(name)
					}
				})
			} else {
				notify.error('No se pudieron guardar los cambios')
			}
		})
		.always(function(r){
			typeof callback == "function" && callback();
		})
	 },
	guardarNombre: function(data){
		
		data.controller = 'agendas'
		data.action = 'saveName'

		$.post(INDEX,data,function(r){
			agendas.set.name(data.id, data.nombre)
		},JSON)

	 }, 
	set: {
		name: function(id, value){
			main.set.nameAgenda(id,value)
			crearCita.set.nameAgenda(id,value)
			config.set.nameAgenda(id,value)
		}
	 }
	
 }, 
familias = {
	change : false , 
	controller : 'familias', 
	data : new Object , 
	eliminar : function () {
		var id = $('#dlgFamilias #id').val(), del = false
			nombre = $('#dlgFamilias #nombre').val(),
			_fnOk = function ( r ){
				if (r.success == true){
					if (del){		
						familias.menu.eliminar( id ) 
					}else{

						familias.menu.ocultar( id ) 

						var baja = ($('#chckOpUsersDel').is(':checked'))?'mostrar_baja' : 'ocultar_baja'
						
						if (id>=0) $("#rowFamilias"+id).addClass(baja) 
					}
				}else{

					$("#familias #rowFamilias"+id).fadeTo("slow", 1)
					notify.error( r.success ) 
						
				}
				$("#rowFamilias"+id).fadeTo("fast", 1)

				dialog.close('dlgFamilias')

			}
		btn.load.show($('#dlgFamilias .cancelar'),false)

		if (confirm ('Desea eliminar la familia?')) 
			familias.sendAjax(DEL , _fnOk)
		 else
			btn.load.hide() 
		
		
	 },
	guardar :function (){
		btn.load.show($('#dlgFamilia .aceptar'),false)
		var  dlg = $('#dlgFamilias') , id = dlg.find('#id').val()
		var _fnOk = function (r) {
			if (r.success){
				if (id == -1){
					//NUEVO
					var mostrar = (r.mostrar==1)?'checked':'';
					$("#familias table").append("\
						<tr id='rowFamilias"+r.id+"'>\
						<td><a name='editar[]' class= 'icon-edit x6' value="+r.id+"></a></td>\
						<td id='familia_"+ r.id + "' class='nombre'>"+r.nombre+"</td>\
						<td class='ico'>\
						<input type='checkbox' name = 'mostrar[]' id='chck"+r.id+" class='mostrar'\
						value="+r.id+" "+ mostrar + "></td></tr>")
					$('#servicios #frmEditar #familia').append("<option value="+r.id+">"+r.nombre+"</option>");
					familias.menu.crear( r.id , r.nombre ) ;
				}else{
					//EDICION
					$('#familias #familia_' + r.id).html(r.nombre);
					$('#familias #rowFamilias' + id ).removeClass('mostrar_baja , ocultar_baja') ;
					$('#sevicios .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
					$('#crearCita .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;

					var estado = (r.mostrar==1)?true:false;
					var $chck = $('#familias #chck'+id);
					$chck.prop("checked",estado);
					$('#servicios #frmEditar #familia option[value='+id+']').html(r.nombre);

					familias.menu.editar( r.id , r.nombre ) ;

				}
				
				dialog.close('dlgFamilias');
			}else{
				notify.error( r.err , 'Error!! ')
			}

				$("#rowFamilias"+id).fadeTo("fast", 1);
		}

		if (id == -1 ){
			(familias.validate.form()) ? familias.sendAjax(SAVE , _fnOk) : btn.load.hide();

		 }else{
			if ($.isEmpty(dlg.find('#nombre').val()))
				notify.error('El campo del nombre no puede estar vacio.','ERROR CAMPO VACIO!')
			else	
				familias.sendAjax(SAVE , _fnOk)
		 }
		
	 },
	sendAjax : function(action , callback){
			var  dlg = $('#dlgFamilias') , id = dlg.find('#id').val()
			var	data = $("#frmEditarFamilia").serializeArray()			
				data.push({name : 'controller' , value : familias.controller})
				data.push({name : 'action' , value : SAVE})

			if (dlg.find('.aceptar').text() == 'Restaurar' && action == SAVE)
				data.push({name : 'baja' , value : 0})
			
			if (action == DEL)
				data.push({name : 'baja' , value : 1})
			

			$.ajax({
				type: "POST",
				dataType: "json",
				data: data, 
				url: INDEX,
				beforeSend: function(){if (id>=0)$("#rowFamilias"+id).fadeTo("slow", 0.30)}
			})
			.done(function(r){ 
				typeof callback == "function" && callback(r)
			})
			.fail(function( jqXHR, textStatus, errorThrown){
				notify.error(jqXHR + '<br/>' +  textStatus + '<br/>' + errorThrown);
				return false;
			})
		},
	menu : {
		a : function(id , name) {
			return  $('<a>').attr('id', id).html( name ) ;
		},
		editar : function ( id ,  nombre ){
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).remove();
				$(this).find('#lstSerSelect').find('#'+id).remove();

			})

			familias.menu.crear( id , nombre ) ; 

		},
		eliminar : function( id ,callback ){
			$("#rowFamilias"+id).remove()
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).remove()
				$(this).find('#lstSerSelect').find('#'+id).remove()
			})
			$('#sevicios .fam' + id ).remove() 
			$('#crearCita .fam' + id ).remove() 
			typeof callback == "function" && callback()
		},
		ocultar : function ( id ,callback ) {
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).addClass('ocultar_baja');
				$(this).find('#lstSerSelect').find('#'+id).addClass('ocultar_baja');
			 })
			$('#sevicios .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
			$('#crearCita .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
			typeof callback == "function" && callback();
		},
		crear : function (id, name ) {

			$('#lstSerMain').each(function(){
				$(this).append(familias.menu.a(id ,name))
			})
			$('#lstSerSelect').each(function(){
				$(this).append(familias.menu.option(id , name))
			})

		},

		option : function (id , name  ) {
			return $('<option>').attr('id', id ).val(id).html( name ) ;
		 },

	 }, 
	dialog: function (id){
		var fnLoad = function (isNew) {
			var dlg = $('#dlgFamilias')
			if (id!=-1){
				dlg
					.find ('#id').val(id).end()
					.find("#nombre").val($('#familias #rowFamilias'+id + ' .nombre ').html()).end()
					.find("#mostrar").attr('checked', $('#familias #chck'+id).prop('checked'));
			}
			if ($('#familias #rowFamilias'+ id ).hasClass('mostrar_baja')) {
				dlg.find('.aceptar').html('Restaurar')
			}
			dlg.find("#id").val(id);
		}
		dialog.open('dlgFamilias',familias.guardar,familias.eliminar,fnLoad)

	 },
	validate : {
		form : function () {  
			var valNom = $('#dlgFamilias #nombre').val(); 
			if ($.isEmpty(valNom)){
				notify.error('El campo del nombre no puede estar vacio.','ERROR CAMPO VACIO!')
				return false ;
			}else {
				return true ;
			}
		 }

	 },
 },
crearCita ={
	tiempoServicios : 0,
	data : new Object(), 
	init : function(){
		var clase = $('#crearCita .contenedorServicios tbody tr').attr('class') ; 
		if (!$.isEmpty(clase)){
			var clase_id = clase.replace(/\D/g,'');
			servicios.mostrar(clase_id) ;
		}
		cargarDatepicker();
	 },
	set : {
		nameAgenda :function(id,name){
			$('#crearCita #lblagenda'+id).text(name)
		}
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
				hora : sec.find('.horas:checked').val(), 
				agenda : crearCita.data.agenda,
				nameCli :crearCita.data.nombre, 
				servicios : idSer ,
				nota : sec.find('#crearCitaNota').val(),
				uTiempo : Math.ceil(parseInt(sec.find('#tSer').text()) / 15) 
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
	horas: {
		iniciar: function(){	

			if (!$('#crearCita #tablas table').length) cargarDatepicker();

			for(let i = 0 ; i <= document.margenDias ; i++){
	
				var date = Fecha.calcular(i ,  Fecha.id )
				crearCita.horas.crear(Fecha.number(date))
			}
			
		 },	
		load : function ($this) {
			tiempoServicios = 0
			var lblTS = $('#tSer')[0]

			if( $this.is(':checked') )
				tiempoServicios += $this.data('time')
			else 
				tiempoServicios -= $this.data('time')

			crearCita.horas.pintar(Fecha.id)
		
			lblTS.innerHTML = tiempoServicios;
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
				crearCita.horas.pintar(id_table)				
			})

		 },		
		pintar: function(id_table, tiempoServicios){

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
				ts = parseInt(Math.ceil(tiempoServicios/15))||0 ,
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

			var context = $('#tablas')
			var activa = context.find('.activa')
			var activar = context.find('#'+ Fecha.id)

			crearCita.horas.crear(Fecha.id)	
		 },
	 },
	reset: function(){
		$('.steperCapa li').hide(function(){
			$('#step0').show()
		});
		_hora =0 
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

			dialog.close('dlgGuardar');
	 },
	stepper: function(index){
		var $visible = $('.steperCapa:visible')
		var $stepper = $('#stepper'+index)
		if($visible.attr('id')==$stepper.attr('id'))return false;
		if (!$stepper.is(':visible')&&$visible.length){
			if(index==0){
				_slider()

			}else if(index==1 &&crearCita.validate.name()){
				crearCita.data.agenda = $('#crearCita').find('input[name="agenda[]"]:checked').val()
				crearCita.data.nombre =  $('#crearCita #cliente').val() 
				$('.tblHoras').empty()

				_slider(servicios.init) 

			} else if(index==2&&crearCita.validate.service()){
				if(crearCita.validate.name())_slider(function(){
					if (_hora!=0){
						$('#crearCita #'+Fecha.id + ' #'+_hora).attr('checked',true);
						crearCita.dialog();
					}
				});
			};
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

 },
config ={
	change : false,
	controller : 'config' ,
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
				oldPass : SHA(oldPass),
				newPass: SHA(newPass) ,
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
				var n = ($('#showInactivas').is(":checked"))?1:0
				main.inactivas.change(n)
				
				$("#config #respuestaLogo").html("<img src="+r+"/logo.png></img>") 
			} else {	
				notify.error('No se ha podido guardar los datos')	
			}
	 		typeof callback == "function" && callback()
		})
		.fail(function( jqXHR, textStatus, errorThrown ){
			alert( jqXHR + ' , '  +  textStatus + ' , ' +  errorThrown )
	 		typeof callback == "function" && callback()
		})

		config.change = false
		},

  },
general = {
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
 },
festivo = {
	dialog : function () {
		dialog.open('dlgFestivos',festivo.guardar, festivo.eliminar)
	 },
	eliminar:	function ($this){
		var self = this 
		var id = $this.parent().parent().attr('id');
		var f =  $this.parent().parent().find('[name="mes[]"]').text();

		$('#festivos #'+id).fadeTo("slow", 0.30);
		data = {
			id : id ,
			controller : 'festivos',
			action : DEL
		}
		$.post(INDEX,data,function(){
			$('#festivos #'+id).hide("explode")

			var index = $.inArray(Fecha.md(f),FESTIVOS)
			if (index>-1) FESTIVOS.splice(index,1)
		},'json');
	 },
	guardar:	function (callback){
		var nombre = $('#dlgFestivos #nombre').val() ,
			fecha = $('#dlgFestivos #fecha').val() ,
			fila = $('#tblFestivos tr:first').clone(),
			data = {
				nombre : nombre ,
				fecha : fecha 	,			
				controller : festivos ,
				action : SAVE}

		if ( $.isEmpty( nombre , fecha ) ){
			notify.error('faltan rellenar los campos' , ' Error festivos') 
			return false 
		 }


		if($.isEmpty(nombre)){
			$('#nuevo [name="nombre[]"]').popover('show');
		 }else{
			if($.isEmpty(fecha)){
				$('#nuevo #dpFestivos').popover('show');
			 }else{
				hideShow('#nuevo .icon-plus')
				$('#nuevo .icon-load').css('display','inline-activa')
				$.post(INDEX ,data,function(r){
					$('#festivos')
						.find('#tblFestivos').append('\
						<tr id="'+r.id+'">\
							<td><a name="eliminar[]"  class= "icon-cancel"></a></td>\
							<td  class=""><span name="nombre[]">'+r.nombre+'</span></td>\
							<td> <span  name="mes[]" >'+Fecha.print(r.fecha)+'</span></td>\
						</tr>\
					').end()
					
					hideShow('#nuevo .icon-plus','#nuevo .icon-load')
					
					FESTIVOS.push(Fecha.md(r.fecha)) ;

					dialog.close() 

				},'json').fail(function(rsp){"ERROR=>"+echo(rsp);})
			 }
		 }
	 },
 },
horario = {
	controller : 'horarios' , 
	section : $('#horarios') , 
	activo:null,
	editar: function (){
		var numeroHorario = $('#hor	arios  #nombre option:selected').val();
		$('#horarios .celda-horario').each(function(){
			var n = $(this).attr('name'); //dia y hora
			var est = $(this).hasClass('color1')?1:0;
			HORARIOS[numeroHorario]['h'+n] = est;
		})

		var cargarHoras = (function(callback){
			main.section.find('div.template')
				.clone()
				.removeClass('template')
				.addClass('editando');

			main.section.find(".editando")
				.removeClass('color1 color2 color-red')
				.each(function(){
					var dia = $(this).data('diasemana');
					var fecha = $(this).attr('id');
					fecha = fecha.substr(4);
					for(let i=0;i<=HORARIOS.length-1;i++){//busco horarios por fecha
						if (HORARIOS[i].FechaIni<=fecha&&HORARIOS[i].FechaFin>=fecha){//compruebo en que horario estoy
							for (let h =1; h<=73; h++){
								let hora =  "h"+dia+h;
								HORARIOS[i][hora]==0?$(this).find('.h'+h).addClass('inactiva'):$(this).find('.h'+h).removeClass('inactiva');
							}
							break;
						}
					}
				})
				.removeClass('editando');
			typeof callback == "function" && callback();
		})()
	 },
	guardar: function (callback){
		var horarios = $('#frmHorario tr').not(':eq(0)')
		var data = new Array();

		if(horario._validate()){
			$.each(horarios,function( index , me ){
 
				data.push({
					id:	me.id,
					agenda: $(this).find('.numero_agenda').val(),
					dia: $(this).find('.dia_semana').val(),
					inicio: $(this).find('.hora_inicio').val(),
					fin: $(this).find('.hora_fin').val()
				})
			})

			$.ajax({
				type:"POST",
				data: { action : SAVE , data : data , controller : horario.controller },
				url: INDEX,
				dataType: 'json'
			})
				.done(function(r,s){
					if(r)
						location.reload();
					else	
						notify.error('No se pudo guardar el horario!!')
					
					typeof callback == "function" && callback();
				})
				.fail(function(rsp){echo("fail =>"+rsp.sql);})
		 }else{
			 notify.error('Debe de completar todos los campos.','Validar formulario');
			 btn.load.hide();
		 }
	 },
	add: function(){
		var dia_semana = $('#horarios .template .dia_semana');
		var numero_agenda  = $('#horarios .template .numero_agenda');

		horario.section.find('tbody tr:first')
			.clone()
			.attr('id',-1)
			.addClass('nuevo')
			.find('.hora_inicio').val('09:00').end()
			.find('.hora_fin').val('20:00').end()
			.find('.dia_semana').val($('option:first', dia_semana).val()).end()
			.find('.numero_agenda').val($('option:first', numero_agenda).val()).end()

			.appendTo('#horarios table')
	 },
	del: function(){
		var selects = $('#horarios #frmHorario input:checked');

		var data =  new Array();
		
		$.each(selects ,function(){
			data.push($(this).val());
		})
		var jsonString = JSON.stringify(data);
		
		$.post(INDEX,{ ids : data , action : DEL , controller : horario.controller },function(r){
			if(r){
				location.reload();
			}
		}, 'json')
	 },
	_validate: function(){
		var $time = $('#horarios #frmHorario .time');
		var return_function = true;
		$.each($time,function(){
			if ($(this).val() == '') return_function = false;
		})
		
		return return_function;
	 },
 },
usuarios = {
	controller : 'usuarios' , 
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
				email: frm.email||'',
				tel: frm.tel||'',
				obs: frm.obs||'',
				status: $.isEmpty(frm.activa)?0:2,
				admin : $.isEmpty(frm.admin)?0:1,
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
		var _fnLoad = function (r) {
			$('#dlgUsuarios').find('#id').val(id)
					
				if (id!=-1){
					var $this = $("#usuarios #rowUsuarios"+id);
					
					var nom = $this.find("[name='nom']").text();
					var email = $this.find("[name='email']").data("value");
					var tel = $this.find("[name='tel']").text();
					var obs = $this.find("[name='obs']").data("value");
					var admin = $this.find("[name='admin']").data("value");
					var baja = $this.hasClass('mostrar_baja');

					$("#dlgUsuarios")
						.find('#nombre').val(nom).end()
						.find('#email').val(email).end()
						.find("#tel").val(tel).end()
						.find("#obs").val(obs).end()
						.find("#admin").attr('checked', admin!=0).end()
						.find("#activa").attr('checked', baja).end()
						.find('#eliminar').val('Eliminar');
				}else{
					$("#dlgUsuarios")
						.find("#nombre").val($('#buscarTxt').val()).end()
						.find("#activa").attr('checked', false).end()
						.find("#admin").attr('checked', false).end()
						.find('#eliminar').val('Cancelar');
				}
		 } , 
		_fnDel = function (r) { 
			usuarios.eliminar($('#dlgUsuarios #id').val(),$('#dlgUsuarios #nombre').val())
		 }
		dialog.open('dlgUsuarios',function(){usuarios.guardar(id)},_fnDel,_fnLoad)

	 },
	historial: function ($this){
		alert('temporalemente inhabilitado')
		/*
    	var id =$this.parent().parent().data('value');  

		$.getJSON(INDEX,{id:id},function(data){
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
				dialog.open('dlgHistorial');
			});
		})
		*/
	 },
	select: function (letra) {

		$('#usuarios')
			.find('.c3').removeClass('c3').end()
			.find('#menu'+letra).addClass('c3').end()
			.find('tbody tr').hide().end()
			.find('.name[id^='+letra.toLowerCase()+']').parent().show()
	 },
	buscar: function (txt){
		var txt =  normalize(txt);
		usuarios.select(txt.toUpperCase());
		var txt = txt.replace(/\s/g, "");
		txt = txt.toLowerCase();
		$("#usuarios").find(".body").hide().end()
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
 },
estilos = {
	border : false , 
	init : function () {
		this.border = $('#sldBorderRadius').data('position') ;
	 },
	test : function ( value ) {
		this.border = value ;
		$('#btnTest').css('border-radius' , value)
	 },
	save : function () {
		
		
		data = {
			color1 : $('#btnColor1').val() ,
			color2 : $('#btnColor2').val() ,
			border : this.border , 
			text1 : $('#btnText1').val() , 
			text2 : $('#btnText2').val() , 
			controller : 'estilos' , 
			action : SAVE
		}
		$.post(INDEX,data,function(r){ 
			if (r) location.reload(); 
		},'json')
	}, 
	_getTheColor : function  (colorVal) {
		var theColor = "";
		if ( colorVal < 50 ) {
					myRed = 255;
					myGreen = parseInt( ( ( colorVal * 2 ) * 255 ) / 100 );
			}
		else 	{
					myRed = parseInt( ( ( 100 - colorVal ) * 2 ) * 255 / 100 );
					myGreen = 255;
			}
		theColor = "rgb(" + myRed + "," + myGreen + ",0)"; 
		return( theColor ); 
	}
 }, 
notas = {
	nombreDlg : 'dlgNotas',
	dir : 'right',
	init : function(){
		cargarDatepicker();
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
		
		dialog.open(this.nombreDlg,this.save,()=>this.delete(id),fnLoad)

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

				let $linea = ($("#notas #trNotas"+data.id).length)
				?$("#notas #trNotas"+data.id)
				:$('#notas tbody tr').first().clone().attr('id','trNotas'+r.id).appendTo('#notas table tbody')

				$linea.find('.idFecha').text(data.fecha)
				$linea.find('.idHora').text(data.hora)
				$linea.find('.idDescripcion').text(data.nota)
				notify.success('Su nota ha sido guardada')
			} else{
				notify.error('No se ha podido guardar la nota')
				echo (r)
			} 
			typeof callback == "function" && callback();
		 },JSON)

	 }, 
	delete : function(id,callback){

		var data = {
			controller : 'notas' , 
			action : DEL , 
			id : id
		}
		$.post(INDEX, data,
			function (r, textStatus, jqXHR) {
				if (!r.success) {
					notify.error('No se ha podido eliminar la nota')
					echo (r)
				} 
				typeof callback == "function" && callback();
			},
			JSON
		)
	 },
	sync : function(){
		notas.slide()
		if (!$('#txtNotas').length) return false
		data = {
			controller : 'notas' , 
			action : GET , 
			fecha : Fecha.sql
		}
		$.post(INDEX, data,
			function (r, textStatus, jqXHR) {
				var html = (r.success) ? r.data : '' 				
				$('#txtNotas').html(html)
			},
			JSON
		)
		return true
	 },
	slide : function(){
		var lastDate = $('.datepicker').val()
		notas.dir = (Date.parse(Fecha.general) > Date.parse(Fecha.sql(lastDate)))?'left':'right'
		$('#txtNotas').hide('slide',{ direction: notas.dir },750, function(){
			notas.dir =  (notas.dir=='right')?'left':'right'
			$('#txtNotas').show('slide',{direction:notas.dir},750)	
		})
	 }
 },
logs = {
	get : function(days){
		data = {
			controller :'history', 
			action : GET , 
			days : days
		}
		$.post(INDEX, data,
			function (html, textStatus, jqXHR) {
				$('#history').html(html)
			},
			'html'
		)
	} 
 }
$(function(){
	cargarDatepicker()
	colorearMenuDiasSemana()
	main.inactivas.change(localStorage.getItem("showRows"))
	main.lbl.widht = $('#main .dia.activa tr.active').find('.celda').first().width() - 11 
	main.lbl.style()
	main.lbl.droppable()

	$('body').on('click',".idDateAction",function(){
		
		if(!$(this).data('disabled')) {
			sincronizar($(this).data('action'));
		}
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

	$('#config')
		.on('change','input',function(){
			config.change = true;
		})

	$('#crearCita')
		.on('click','a',function(){servicios.mostrar($(this).attr('id'))})
		.on('change','.lstServicios ',function(){servicios.mostrar($(this).val())})
		.on('click','.horas',crearCita.dialog)
		.on('click','.siguiente',function(e){crearCita.stepper($('div [id^="stepper"]:visible').data('value') + 1);})
		.on('blur','#cliente',crearCita.validate.name)
		.on("swipeleft",'.tablas')
		.on('click','.idServicios',function(){crearCita.horas.load($(this))})
		.on('click','.cancelar',function(){mostrarCapa('main')})
	$('#familias')
		.on('click','table .icon-edit',function(){
			familias.dialog($(this).attr('value'));
		})

	$('#general')
		.on('click','#btnCambiarPass',function(){
			dialog.open('dlgCambiarPass',config.pass,null,function(){
				dialog.open('dlgCambiarPass')
			})
		})

	$('#main')
		.on('click','.lbl',function(e){
			main.z_index +=  1 
			$(this).css({'z-index': main.z_index })	
			})
		.on('click','.row_1, .row_2',function(){main.lbl.resize($(this))})
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
				nombre : $(this).val()
			 }
			 agendas.guardarNombre(data)
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
					.parent()
						.show('slide',{direction:'right'})
					.end()
					.focus()

			}else{
				menu.load();
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
		.on('change','#selShowByTime', function(){logs.get($(this).val())})
		.find('[name="menu[]"]').click(function(){
			var capa = $(this).data('capa') ;
			if (capa == 'main'){
				mostrarCapa('main' ,  true ) 
			}else{
				mostrarCapa($(this).data('capa'));
			}
			$('.app-bar-pullmenu ').hide('blind');
		 })



	$("#festivos")
		.on('click',"[name='eliminar[]']",function(){festivo.eliminar($(this))})

	$('#agendas')
		.on('#cancelar',function(){dialog.close()})
		.on('submit','#frmAg',function(e){
			e.preventDefault();
			guardarAgenda()
		 })
		.on('change','input',function(){
			agendas.change =  true;
		 })
		 .on('click','.fnDel',function(){
			 agendas.del($(this).attr('id'))
		 })

	$('#servicios')
		.on('click','a',function(){servicios.mostrar($(this).attr('id'),$('#servicios'))})
		.on('change','.lstServicios ',function(){servicios.mostrar($(this).val())})
		.on('change','#familia',function(){familias.change = true})
		.on( "click", "[name*='editar']", function(e){servicios.dialog($(this).attr('value'))})
		.find('option:first-child').attr('selected','selected')
		
		$('#familias input[name*="mostrar"]')
			.change(function(){
				var mostrar = ($(this).is(':checked'))?1:0;
				var id = $(this).attr('id');
				familias.chckGuardar(id, mostrar);
			});

	$("#usuarios")
		.on('click','[name*="editar"]',function(){
			var id = $(this).parents('tr:first').data('value')
			usuarios.dialog(id)
		 })
		.on('click',"[name^='historia']",function(e){usuarios.historial($(this))})
		.on('click','#mainLstABC a',function(){
			usuarios.select($(this).html());
		 })
		.on('change','#lstABC',function(){usuarios.select($(this).val())})
		.on('click','.icon-search',function(){
			$('#popupHistorial').hide()
			$('.popup-overlay').hide()
			mostrarCapa('main')
			sincronizar(null, $(this).parent().parent().data('fecha'))
		 })
	$('#notas')
		.on( "click", ".fnEdit", function(e){notas.dialog($(this).attr('value'))})
		.on('click','.fnDel', notas.delete)

 })