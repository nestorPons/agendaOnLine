
if ($('#navbar').is(':hidden')) $('#navbar').show('blind');
var urlPhp = "../../php/admin/"; 
var admin = true;
var HORARIOS = document.horarios;
var FESTIVOS = document.festivos;
var _hora = 0; 

function sincronizar( dias, date , callback ){

	var fecha = date||Fecha.general;
	
	if (dias)
		fecha =  Fecha.calcular(dias, fecha);
	else
		dias = 0;
	
	Fecha.general = Fecha.sql(fecha);
	Fecha.id = Fecha.number(Fecha.general);

	main.sincronizar(dias,function () {
		crearCita.sincronizar();
		typeof callback == "function" && callback();
	})

	colorearMenuDiasSemana();
	$('.datepicker').each(function(){
		$(this)
			.val(Fecha.print(fecha))
			.datepicker("setDate",Fecha.print(fecha));
	})
}
function mostrarCapa(capa, callback){
	
	data = {
		action : capa , 
		fecha :  Fecha.sql ,
	}
	if($('#'+capa).is(':visible')) return false;

	$('#chckOpUsersDel').prop( "checked", false ) ;
	$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja') ;

	if($('#'+capa).is(':empty') ){
		var url = 'controller.php'
		$.get(url,data,function(html){

			$('#'+capa).html(html).promise().done(__INIT__);
			function __INIT__ (){
				if(capa=='crearCita') crearCita.init();
				if(capa=='servicios') servicios.init();
				if(capa=='usuarios') usuarios.init();
			}

		},'html')
	}
	
	if($('#config').is(':visible')&&config.change) config.guardar();
	if($('#agendas').is(':visible')&&agendas.change) agendas.guardar();
	if($('#crearCita').is(':visible')) crearCita.reset();


	$('.capasPrincipales').hide();
	$('#'+capa).fadeIn();

	menu.status(capa);

	if(capa=='main') $('#'+Fecha.id).show();

	btn.load.reset();

	$('html,body').animate({scrollTop:0}, 500);
	$('#navbar')
		.find('a').removeClass('selected').end()
		.find('[data-capa="'+capa+'"]').addClass('selected')
	typeof callback == "function" && callback();
}
var main ={	
	status : document.mainStatus ,
	z_index : 2 ,
	sincronizar: function (dir,callback){

		var idFecha=Fecha.id;
		var diaFestivo = $.inArray(Fecha.md(Fecha.general),FESTIVOS)!=-1;
		
		(diaFestivo)?$('.datepicker').addClass('c-red'):$('.datepicker').removeClass('c-red');

		if (!$('#main #'+idFecha).length) main.crearDias(callback);

		//no lo meto en fin de carga para avanzar mas rapido
		if (idFecha != $('#main .dia.activa').attr('id')) _sliderDias(idFecha,dir) ; 

		function _sliderDias(idFecha,dir){
			var 	dir= dir||0;
			if (dir>0||dir=='right'){
				var ent = 'right';
				var sal = 'left';
			}else{
				var ent = 'left';
				var sal = 'right';
			}

			$("#main .cuerpo")
				.hide("slide", { direction: sal }, 750,function(){
					$('.dia.activa').removeClass('activa')
					$('#'+idFecha).addClass('activa')
					$("#main .cuerpo")
						.show("slide", { direction: ent }, 750,function(){
							//fin
						});
				})

		}
	},
	crearDias: function(callback){

		var mD = parseInt(document.margenDias)/2;
		var fechaIni = Fecha.calcular(-1*mD,Fecha.general);
		var fecha = fecha||Fecha.general;
		var dias = $('#main .cuerpo .dia');
		var ids = new Array();

		$.each(dias,function(){
			ids.push($(this).attr('id'));
		})

		$.ajax({
			type:"POST",
			url: urlPhp+'main/view.function.php',
			dataType: 'html',
			data: {
				fecha : Fecha.general ,
				ids :JSON.stringify( ids ),
				action : 'view'
			},
			cache: false
		})
		.done(function(html){
			$('#main .cuerpo').append(html);

			crearCita.horas.iniciar(); 
			
			typeof callback == "function" && callback();
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
	responsive: function($this){
		var a = $this.val();
		$('.cuerpo').fadeOut('fast',function(){
			$('.dia .celda').not('.num').addClass('hiddenim')
			$('#main .agenda'+a).removeClass('hiddenim')
			$('.cuerpo').fadeIn('fast')
		})
	},
	edit : function (idCita) {
		var $this = $('#'+idCita+'.lbl') 
		var data = {
			idCita : idCita ,
			agenda : $this.parents('.celda').attr('agenda') ,
			nombre : $this.find('.nombre').text().trim() ,
			idUsuario : $this.find('.nombre').attr('id')  ,
			fecha : Fecha.sql($this.parents('.dia').attr('id')) ,
			hora :  $this.parents('tr').data('hour'),
			obs :  $this.find('.note').text().trim() ,
			servicios : new Array() ,
			status : false ,
			action : 'edit' ,
		}
		
		var tiempoTotal =  0

		var _addRow = function (id , codigo , descripcion ,tiempo ){
				data.servicios.push(id)

				$('#dlgEditCita .template')
					.clone()
						.removeClass('template')
						
						.find('.codigo')
							.attr('id_codigo',id)
							.html(codigo + " => ")
						.end()
						.find('.descripcion')
							.html(descripcion)
						.end()
						.appendTo($('#dlgEditCita').find('#codigos'))

				tiempoTotal += parseInt(tiempo)	
				arrServicios.push({id ,  codigo ,  descripcion , tiempo}) 

			}
		var event = function () {
			$('#dlgEditCita').on('change','#lstServ',function(){
				data.status = true 
				var select  = $(this).find(':selected')

				_addRow (
					select.val() ,
					select.attr('codigo') , 
					select.text() , 
					select.attr('tiempo')
				)

				$(this).val('')
			})

			$('#dlgEditCita').on('change','input',function(){
				data.status = true 
			})

		}
		var _ok = function () {
			//EDITAR SERVICIOS ¡
			if ( data.status ) {

				var url = urlPhp+'main/edit.php';

				var tiempoCita = Math.ceil(tiempoTotal / 15) ; 
				$this.find('.servicios').empty() 
				
				$this.removeClass(function(){
					var clases = $(this).attr('class').split(' ')
					var nuevaClase = '';
					for (i = 0 ; i < clases.length ; i++) {
							nuevaClase += (i != 1 )? clases[i] : 'row_'+ tiempoCita ;
							nuevaClase += ' '
						}

					$(this).attr('class', nuevaClase )

				}) 
				for(let i = 0 ; i < arrServicios.length ; i++){
					let self = arrServicios[i]

					//if (!$this.find('.servicios').find('[id_codigo = '+ self.id +']').length)
					main.lbl.crear.servicio( idCita , self.id  , self.codigo , self.descripcion , self.tiempo ) ; 
					
				}


				//AKI :: hay que arreglar la forma que se edita el servicio 


				$.ajax({
					type: "POST",
					dataType: "json",
					url: url,
					data: data,
				})
				.done(function(r){
					popup.close('dlgEditCita')
				})
				.fail(function(r){console.log(r)})
			} else {
				
				popup.close('dlgEditCita')

			}
		}
		var _cancel = function (){
			/*
			dialog.close('.dialog',function(){
				$('#lstChckSer').empty();
				$('#dlgEditCita').removeData('idCita')
			});
			*/
		}

		dialog.create('dlgEditCita',event,function(){
			tiempoTotal= 0 
			arrServicios = [] 
			$('#dlgEditCita #codigos').html('') 

			$('#dlgEditCita')
				.data('idCita',idCita)
				.find('#id').val(idCita).end()
				.find('#nombre')
					.val(data.nombre)
				.end()
				.find('#obs')
					.val(data.obs)
				.end()
				.find('#fecha')
					.val(data.fecha)
				.end()
				.find('#hora')
					.val(data.hora)
			
			$this.find('.codigo').each(function(){
			
				_addRow(
					$(this).attr('id_codigo') , 
					$(this).html() , 
					$(this).attr('des_codigo') ,
					$(this).attr('tiempo')
				)
			})

			dialog.open('#dlgEditCita',_ok,_cancel);

		});

	},
	del: function(idCita){
		var url = urlPhp+'main/controller.php'
		var data = {
			idCita : idCita , 
			action : 'del'
		}
		$.post(url , data ,function(r){

			if (r) main.lbl.eliminar(idCita);
	
		},'json')
		.fail(function( jqXHR, textStatus, errorThrown ) { echo (jqXHR.responseText) });
	},
	guardarNota: function($this){
		var txt = $this.find('input').val();
		var id = $this.parents(':eq(3)').attr('idcita')
		var url = urlPhp + 'agendas/notasGuardar.php';
		if (!$.isEmpty(txt)){
			$this.find('.icon-load').fadeIn();
			$.get(url,{id:id,txt:txt},function(r){
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
	inactivas: function(){
		var url = urlPhp+'main/estado_visible_guardar.php';
		if( main.status == 0 ){
			main.status = 1 ;
			$('#btnShow')
				.find('.menulbl').html('Ocultar').end()
				.find('.on').show().end()
				.find('.off').hide().end()
			$('#main .disabled').removeClass('disabled');
		}else{
			main.status = 0 ;
			$('#btnShow')
				.find('.menulbl').html('Mostrar').end()
				.find('.off').show().end()
				.find('.on').hide().end()
			$('#main .fuera_horario').parent().addClass('disabled');

		}
		$.get(url,{status : main.status});
		
	},
	poppup:function(id){
		dialog.create('dlgEditCita',function(){
						
			//EDITANDO...
			var $this = $("#servicios #rowServicios"+id);
			
			
			var cod = $this.find("[name='cod']").text();
			var des = $this.find("[name='des']").text();
			var time = $this.find("[name='time']").text();
			var price = $this.find("[name='price']").data("value");
			var fam = $this.find("[name='fam']").data("value");

			$('#frmEditarServicios')
				.find('#codigo').val(cod).end()
				.find('#descripcion').val(des).end()
				.find('#tiempo').val(parseInt(time)).end()
				.find('#precio').val(price).end()
				.find('#familia').val(fam).end()
				.find('#eliminar').val('Eliminar');

			dialog.open('#dlgServicios',servicios.guardar,servicios.eliminar);
			if ($('#servicios #rowServicios'+ id ).hasClass('mostrar_baja')) {
				$('#dlgServicios .aceptar').html('Activar')
			}

		});
	},
	refresh: function () {

	},
	lbl:{
		crear: {
			servicio : function (idCita , idCodigo  , codigo , descripcion ,tiempo ) {
				$('<div>')
					.append($('<span>', {
							'class' : 'icon-angle-right' ,
						})
					)
					.append($('<span>', { 
							'class' : 'codigo' ,
							des_codigo : descripcion , 
							id_codigo : idCodigo , 
							tiempo : tiempo , 
							text : codigo 
						})
					)
					.appendTo($('#'+idCita+' .servicios'))
			}, 
		},
		eliminar: function(idCita,callback){
			var $this = $('#'+idCita+'.lbl') ;
			if (confirm('Desea eliminar la cita con id: ' + idCita + ' ?')){
				$this
					.parents('.celda').removeClass('doble').end()
					.hide('explode')
					.remove()
			}

			main.lbl.color();
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
					$(this).find('.doble[agenda="'+a+'"]')
						.each(function(){
							var $this  = $(this).find('.lbl')
							
							color = color == 'color1'?'color2':'color1';
														
							$this.removeClass('color1 color2 color3 color-admin')
							$this.addClass(color);

						})
				}
			})
			typeof callback == "function" && callback();
		},
		draggable : function(){
			$('.lbl').each(function(){
				var limit = $(this).parents('.dia').attr('id')
				$(this).draggable( {
					containment: "#"+limit , 
					opacity : 0.70 , 
					zIndex: 100 , 

				}) 
			})
		},
		droppable : function () {
		/*
			$( ".celda" ).each(function(){
				var id = $(this).parents('.dia').attr('id')
				$(this).droppable({
					classes: {
						"ui-droppable-active": "ui-state-active",
						"ui-droppable-hover": "ui-state-hover"
					},
				})
			}
		*/
		},	
	
	}
}
var menu = {

	status: function (capa){
		var add = $('#btnAdd');
		var reset = $('#btnReset');
		var search = $('#btnSearch');
		var save = $('#btnSave');
		var show  =  $('#btnShow')
		var edit  =  $('#btnEdit')
		var options  =  $('#btnOptions')
		var del  =  $('#btnDel')

		menu.disabled(add,reset,search,save,show,edit,options);

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
				menu.enabled(save)
				break;
			case 'festivos':
				menu.enabled( add ) ;
				break;
			case 'general':
				menu.enabled(save) ;
				break ;
		}
		$('#navbar').resize();
	},
	save:function (){
		var loadShow = function (){
			$('#btnSave')
				.find('.icon-floppy').hide().end()
				.find('.icon-load').css('display','inherit')
		}();
		var _loadHide = function (){
			$('#btnSave')
				.find('.icon-load').hide().end()
				.find('.icon-floppy').show();
		};
			switch($('.capasPrincipales:visible').attr('id')) {
			case 'config':
				config.guardar(_loadHide);
				break;
			case 'horarios':
				horario.guardar(_loadHide);
				break;
			case 'agendas':
				agendas.guardar(_loadHide);
				break;
			case 'festivos':
				festivo.guardar();
				break;
			case 'general':
				general.guardar(_loadHide);
				break;
		}
	},
	show: function (){
		switch($('.capasPrincipales:visible').attr('id')) {
			case 'main':
				main.inactivas();
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
			case 'usuarios':
				usuarios.poppup(0);
				break;
			case 'servicios':
				 servicios.poppup(0);
				break;
			case 'familias':
				familias.mostrarPoppup(-1);
				 break;
			case 'horarios':
				horario.add()
				break
			case 'festivos' :
				festivo.dialog() 
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
		menu.exit();
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
}
var agendas = {
	change: false ,
	guardar: function (callback){
		$.ajax({
			type: "POST",
			dataType: "json",
			data: $('#agendas #frmAg').serialize(),
			url: urlPhp+'agendas/guardar.php'
		})
		.done(function(){
			notify.success('Los cambios han sido guardados');
			agendas.change = false;

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
		})
		.always(function(r){
			typeof callback == "function" && callback();
		})
	}
}
var familias = {
	change : false , 
	eliminar : function () {

		btn.load.show($('#dlgFamilias .cancelar'),false)

		var id = $('#dlgFamilias #id').val();
		var nombre = $('#dlgFamilias #nombre').val();

		if ( $('#rowFamilias'+id).hasClass('mostrar_baja') ){
			var mens = 
			"Si elimina definitivamente la familia " + nombre + " y se perderan todos los servicios y citas relacionados con esta (No se aconseja).  \n ¿Desea continuar?"  ;
			var del = true ;
		}else{
			var mens = "Deseas eliminar la familia " + nombre + "?" ;
			var del = false ; 
		}
			
	
		if (confirm (mens)) {
			_del() ;
		}else{
			btn.load.hide() ; 
		}

		function _del(){
			$.ajax({
				type: "GET",
				data: {id:id},
				url: urlPhp + "familias/eliminar.php",
				dataType: "json",
				beforeSend: function(){if (id>=0)$("#rowFamilias"+id).fadeTo("slow", 0.30)}
			})
			.done(function(mns){
				if (mns == true){
					if (del){
		
						familias.menu.eliminar( id ) ;
					}else{
						var baja ; 
						familias.menu.ocultar( id ) ;

						if($('#chckOpUsersDel').is(':checked')){
							baja = 'mostrar_baja' ;
						}else{
							baja = 'ocultar_baja' ;
						}
						if (id>=0) $("#rowFamilias"+id).addClass(baja) ;
					}
				}else{

					$("#familias #rowFamilias"+id).fadeTo("slow", 1) ;
					notify.error(mns,'ERROR') ; 
					
				}
				$("#rowFamilias"+id).fadeTo("fast", 1)

				dialog.close('#dlgFamilias');

			}).fail(function(mns){
				console.log("ERROR =>"+mns);
				$("#familias #"+id).fadeTo("slow", 1);
			});

		}
	},
	guardar :function (){
		btn.load.show($('#dlgFamilia .aceptar'),false);
		
		if (familias.validate.form()){

			var id = $('#dlgFamilias #id').val();
			$.ajax({
				type: "POST",
				dataType: "json",
				data: $("#frmEditarFamilia").serialize(),
				url: urlPhp+"familias/guardar.php",
				beforeSend: function(){if (id>=0)$("#rowFamilias"+id).fadeTo("slow", 0.30)}
			})
			.done(function(data){
				if (data.success){
					if (id>=0){
						//EDICION
						$('#familias #' + normalize(data.nombre) ).html(data.nombre);
						$('#familias #rowFamilias' + id ).removeClass('mostrar_baja , ocultar_baja') ;
						$('#sevicios .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;
						$('#crearCita .fam' + id ).removeClass('mostrar_baja , ocultar_baja') ;

						var estado = (data.mostrar==1)?true:false;
						var $chck = $('#familias #chck'+id);
						$chck.prop("checked",estado);
						$('#servicios #frmEditar #familia option[value='+id+']').html(data.nombre);

						familias.menu.editar( data.id , data.nombre ) ;

					}else{
						//NUEVO
						var mostrar = (data.mostrar==1)?'checked':'';
						$("#familias table").append("\
							<tr id='rowFamilias"+data.id+"'>\
							<td><a name='editar[]' class= 'icon-edit x6' value="+data.id+"></a></td>\
							<td id='"+normalize(data.nombre)+"' class='nombre'>"+data.nombre+"</td>\
							<td class='ico'>\
							<input type='checkbox' name = 'mostrar[]' id='chck"+data.id+" class='mostrar'\
							value="+data.id+" "+ mostrar + "></td></tr>")
						$('#servicios #frmEditar #familia').append("<option value="+data.id+">"+data.nombre+"</option>");
						
						familias.menu.crear( data.id , data.nombre ) ;

					}
					
					dialog.close('#dlgFamilias');
				}else{
					notify.error( data.err , 'Error!! ')
				}

					$("#rowFamilias"+id).fadeTo("fast", 1);

			})
			.fail(function( jqXHR, textStatus, errorThrown){
				notify.error(jqXHR + '<br/>' +  textStatus + '<br/>' + errorThrown);
				return false;
			})
		}else{
			btn.load.hide();
		}
		
	},
	menu : {

		editar : function ( id ,  nombre ){
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).remove();
				$(this).find('#lstSerSelect').find('#'+id).remove();

			})

			familias.menu.crear( id , nombre ) ; 

		},
		eliminar : function( id ,callback ){
			$("#rowFamilias"+id).remove();
			$('.menuServicios').each(function(){
				$(this).find('#lstSerMain').find('#'+id).remove();
				$(this).find('#lstSerSelect').find('#'+id).remove();
			})
			$('#sevicios .fam' + id ).remove() ;
			$('#crearCita .fam' + id ).remove() ;
			typeof callback == "function" && callback();	
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
		a : function(id , name) {

			return  $('<a>').attr('id', id).html( name ) ;
	
		},
		option : function (id , name  ) {

			return $('<option>').attr('id', id ).val(id).html( name ) ;

		},

	}, 
	mostrarPoppup: function (id){
		dialog.create('dlgFamilias',function(){
			if (id!=-1){
				$('#dlgFamilias #frmEditarFamilia')
					.find ('#id').val(id).end()
					.find("#nombre").val($('#familias #rowFamilias'+id + ' .nombre ').html()).end()
					.find("#mostrar").attr('checked', $('#familias #chck'+id).prop('checked'));
			}else{
			}

			dialog.open('#dlgFamilias',familias.guardar,familias.eliminar);
			if ($('#familias #rowFamilias'+ id ).hasClass('mostrar_baja')) {
				$('#dlgFamilias .aceptar').html('Activar')
			}
			$("#dlgFamilias #frmEditarFamilia #id").val(id);
		});
	},
	validate : {
		form : function () {  
			var valNom = $('#dlgFamilias #nombre').val(); 
			if ($.isEmpty(valNom)){
				notify.error('El campo del nombre no puede estar vacio.','ERROR CAMPO VACIO!')
				return false ;
			}else {
				return familias.validate.name(valNom) ;
			}
		},
		name : function (name) {
			var idName = $('#dlgFamilias #id').val() ;
			var obj = $('#familias #' +  normalize(name) ) ;

			if(obj.length == 0 ){
				return true ;
			}else{
				if (obj.parents('tr').attr('id') != 'rowFamilias'+idName){
					notify.error('El nombre no puede estar repetido.','Error crear familia')  ;
					return false ;
				}else{
					return true ;
				}
			}
		}
	},
}
var crearCita ={
	init : function(){
		var clase = $('#crearCita .contenedorServicios tbody tr').attr('class') ; 
		if (!$.isEmpty(clase)){
			clase_id = clase.replace(/\D/g,'');
			servicios.mostrar(clase_id) ;
		}
	},
	idUser : function () {
		var cli = $('#crearCita #cliente').val();
		var  nombre = normalize(cli);
		return parseInt($('#lstClientes [value="'+cli+'"]').text())||0;
	}, 
	sincronizar: function(callback){
		$('#crearCita #tablas .activa').removeClass('activa');

		if(!$('#crearCita #'+Fecha.id).length) crearCita.horas.iniciar();
		
		$('#crearCita #'+Fecha.id).addClass('activa');

	},
	cliente: function (){
		var url = urlPhp + 'usuarios/guardar.php';
		var nombre = $('#crearCita #cliente').val();
		usuarios.guardar(0,nombre,btn.load.hide);
	},
	dialog: function (){
		dialog.create('dlgGuardar',function(){
			var str_servicios ="";
			$('#crearCita [name="servicios[]"]:checked')
				.each(function(){
					str_servicios += $(this).attr('id') + ", ";
				})
			str_servicios = str_servicios.slice(0,-2);

			var h = $('#crearCita [name="hora[]"]:checked').val();
			var hora = new Date(h * 1000).format('hh:mm') ; 
			$('#dlgGuardar')
				.find('#lblHora').html(hora).end()
				.find('#lblFecha')
					.html(Fecha.print(Fecha.general)).end()
				.find('#lblCliente').html($('#crearCita #cliente').val()).end()
				.find('#lblSer').html(str_servicios)
			
		},function(){
			dialog.open('#dlgGuardar',crearCita.guardar, dialog.close)
		})
	},
	guardar: function(){

		if(crearCita.validate.form()){
			var url = urlPhp + 'crearCita/guardar.php';
			var data = $('#crearCita #frmCrearCita').serialize()+"&fecha="+Fecha.general;

			$.post(url,data,function( rsp ){
				if(rsp.ocupado){
					notify.error( rsp.mns.body , rsp.mns.tile );
				}else{	

					mostrarCapa('main' , true );
						
				}
				dialog.close('#dlgGuardar');
			},'json')
			.fail(function( jqXHR, textStatus, errorThrown){
				notify.error(jqXHR + '<br/>' +  textStatus + '<br/>' + errorThrown);
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
	
			if ($('#main #'+Fecha.id).length ) 
				_bucleDias();
			
			function _bucleDias (){
				 
				$('#main .dia').each(function(){
					var self = {
						obj : $('#crearCita #'+$(this).attr('id')),
						id : $(this).attr('id')
					}

					if (Fecha.restar(self.id)>=0 && !self.obj.length) 
						crearCita.horas.crear(self.id);
						
				})		
			}
		},
		crear: function (id_table, callback){

			var contenedor = $('#crearCita .tblHoras');
			
			let table = 
			$('<table>', {
				id : id_table,
			}).appendTo(contenedor);

			$('#main #'+id_table).find('.hora') 
			.each( function( ){
				var cls_fuera_horario = $(this).find('.celda').hasClass('fuera_horario')?'fuera_horario':'';
				$('<tr>' , { 
					id : 'tr' + $(this).attr('id') 
				}).append($('<td>' , {
					'class' : 'hora'
				}).append($('<label>' , {
					'id' : 'lbl' + $(this).attr('id') , 
					'class'  : 'label' , 
				}).append($('<input>' , {
					type  : 'radio' , 
					name : 'hora[]' ,
					value :  $(this).attr('id') , 
					id : $(this).attr('id') , 
				})).append($('<span>' , {
					'class' : 'blHoras ' + cls_fuera_horario  , 
					text : $(this).data('hour') + 'h ' 
				})))).appendTo(table)
			})	
			 _ordenar(table);
			 crearCita.horas.pintar(id_table); 

			//fin
			
			function _ordenar($table, callback){
				var tr = $table.find('tr');
				var filas = tr.length;
				var filasM = Math.round((filas/2));
				var n= 0;
				for ( let f = filasM; f <= filas; f++ ){
					tr.eq(f)
						.detach()
						.find('td')
							.addClass('secondColumn')
							.appendTo(tr.eq(n));
					n++;
				}
				typeof callback == "function" && callback();
			}

		},	
		
		pintar: function(id_table){
		
		//AKI :: pintar horas ocupadas

			var agenda = $('#crearCita input[name="agenda[]"]:checked').val()||1;
			var tiempoServicios = _tiempoServicios();
			var ts = parseInt(Math.ceil(tiempoServicios/15))||0;
			var ocupado = ts;
			var horas = $('#main #'+ id_table+' .hora').reverse();		
			var diaFestivo = !$.inArray(Fecha.md(id_table),FESTIVOS);
			
			var _ocupado = ( hora ) =>  $('#main #'+id_table + ' #'+hora +' .agenda'+agenda + ' table').length >0 ;

			var _fueraHorario  = ($this) =>  $this.hasClass('disabled') ;

			var _colorear = ( hora ) =>	$('#crearCita #'+ id_table + ' #lbl' + hora).addClass('ocupado');

			$(this).find('.ocupado').removeClass('ocupado');

				
			horas.each(function( index , hora ){
				ocupado = $(this).find('.celda').hasClass('fuera_horario')?ts:ocupado;
				if(diaFestivo || _esPasada( hora.id ) || ocupado > 0){
					_colorear( hora.id);
					ocupado--;
				}else{

					if(_ocupado(  hora.id )){

						_colorear( hora.id );
						ocupado = ts ; 
						 
					}
				}
			})

			function _tiempoServicios(){
				var ts = 0;
				$('#crearCita [name="servicios[]"]:checked').each(function() {
					ts += $(this).data('time');
				})
				$('#tSer').html(ts);
				return ts;
			}

			function _esPasada( hora ){
				var diff_fechas = Fecha.restar(id_table); 
				//sumo los minutos a la fecha actua
				var _return = false;
				
				if (diff_fechas<0){

					_return = true;
					
				}else if(diff_fechas == 0 ){
					
					var minTime = document.minTime * 60000;
					var a = new Date(hora*1000);
					var milisegundos = new Date().getTime();
					var f = new Date(milisegundos + minTime);

					_return =  (a<f);
					
				}

				return  _return;

			} 
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

			dialog.close('#dlgGuardar');
	},
	stepper: function(index){
		var $visible = $('.steperCapa:visible');
		var $stepper = $('#stepper'+index);
		if($visible.attr('id')==$stepper.attr('id'))return false;
		if (!$stepper.is(':visible')&&$visible.length){
			if(index==0)_slider();
			else if(index==1 &&crearCita.validate.name()){

				_slider(servicios.init) ;

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
			var dir = $visible.data('value')>0||1;
			var dirEntrada = index-dir<0?'right':'left';
			var dirSalida = dirEntrada=='right'?'left':'right';

			$('.stepper') //esto es para colorear el stepper activo
				.find('li').removeClass('current').end()
				.find('#step'+index).addClass('current');
			$('#crearCita').find('.steperCapa').hide();
			$visible.hide("slide", { direction: dirSalida }, 750,function(){
				$stepper
					.removeClass('hidden')
					.show("slide", { direction: dirEntrada }, 750, function(){$('.tile-active').height('auto')})
			})
			typeof callback == "function" && callback();
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
				str = normalize(cliente);

				if ($('#lstClientes [data-id="'+str+'"]').length==0){
					$this.addClass('input-error');

					dialog.create('dlgCliente',function(){
						dialog.open('#dlgCliente',crearCita.cliente);
					})

				}else{
					$('#crearCita #lblCliente').html($this.val());
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
			crearCita.sincronizar();
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
var config ={
	change : false,
	pass: 	function (){ 
		var $newPass = $('#dlgCambiarPass #newPass');
		var $repeatPass = $('#dlgCambiarPass #repeatPass');
		var url =  urlPhp + 'config/pass.php';
		var data = {
			oldPass : SHA1($('#dlgCambiarPass #oldPass').val().trim()),
			newPass: SHA1($('#dlgCambiarPass #pass').val().trim()) 
		}
		if(general.validar()){
			$.post(url,data,function(r){
				if(r.success){
					notify.success('Contraseña cambiada' , 'Guardada') ;
						
					$('#dlgCambiarPass')[0].reset();

					dialog.close('#dialogs #dlgCambiarPass');					

				}else{
					notify.error( r.respond ) ; 
				}
				btn.load.hide();
			},'json')
			.fail(function(r){alert(r)})
		}else{
			btn.load.status=false;
			notify.error('Algun dato no esta correcto, verifique el formlario.') ;
		}
	},
	guardar: function (callback){
	
		var formData = new FormData($("#config form")[0])
		var std = $('#config #frmConfig #showInactivas').is(':checked')
		var ruta = "../../php/admin/config/guardar.php"

		main.inactivas(std);

		$.ajax({
			url: ruta,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
		})
		.done(function(r){
			if (r.success==true && r.err == true){
				notify.success('Guardado con éxito.')
				$("#config #respuestaLogo").html(r.img) 
			} else {	
				notify.error(r.err)	
			}
	 		typeof callback == "function" && callback()
		})
		.fail(function( jqXHR, textStatus, errorThrown ){
			alert( jqXHR + ' , '  +  textStatus + ' , ' +  errorThrown )
	 		typeof callback == "function" && callback()
		})

		config.change = false
	},

}
var general = {
	guardar: function (callback){
		var  data = $('#general form').serialize();
		var url  = urlPhp+'general/guardar.php';
		$.post(url,data, function(r) {
			
			notify.success( 'Configuración guardada') ; 
			typeof callback == "function" && callback();
		},'json')
		.fail(function(r){console.log(r)})
	},
	validar: function () {
		return $('#dlgCambiarPass .input-success').length == 3 ;
	}
}
var festivo = {
	dialog : function () {
		dialog.create('dlgFestivos',null,function(){
			dialog.open('#dlgFestivos',festivo.guardar, festivo.eliminar);	
		})
	},
	eliminar:	function ($this){
		var id = $this.parent().parent().attr('id');
		var f =  $this.parent().parent().find('[name="mes[]"]').text();

		$('#festivos #'+id).fadeTo("slow", 0.30);
		var url = urlPhp + 'festivos/eliminar.php';
		$.get(url,{'id':id},function(){
			$('#festivos #'+id).hide("explode")

			var index = $.inArray(Fecha.md(f),FESTIVOS);
			if (index>-1)
				FESTIVOS.splice(index,1)
		});
	},
	guardar:	function (callback){
		var nombre = $('#dlgFestivos #nombre').val() ; 
		var fecha = $('#dlgFestivos #fecha').val() ;

		if ( $.isEmpty( nombre , fecha ) ){
			notify.error('faltan rellenar los campos' , ' Error festivos') 

			return false 
		}

		var data = {
				nombre : nombre , 
				fecha : fecha ,				
			}
		var url = urlPhp + 'festivos/guardar.php';

		var fila = $('#tblFestivos tr:first').clone();

		
		if($.isEmpty(nombre)){
			$('#nuevo [name="nombre[]"]').popover('show');
		}else{
			if($.isEmpty(fecha)){
				$('#nuevo #dpFestivos').popover('show');
			}else{
				hideShow('#nuevo .icon-plus')
				$('#nuevo .icon-load').css('display','inline-activa')
				$.post(url,data,function(r){
					$('#festivos')
						.find('#tblFestivos').append('\
						<tr id="'+r.id+'">\
							<td><a name="eliminar[]"  class= "icon-cancel c5 x6"></a></td>\
							<td  class="aling-left"><span name="nombre[]">'+r.nombre+'</span></td>\
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
}
var horario = {
	activo:null,
	editar: function (){

		var numeroHorario = $('#horarios  #nombre option:selected').val();
		$('#horarios .celda-horario').each(function(){
			var n = $(this).attr('name'); //dia y hora
			var est = $(this).hasClass('color1')?1:0;
			HORARIOS[numeroHorario]['h'+n] = est;
		})

		var cargarHoras = (function(callback){
			$('#main div.plantilla')
				.clone()
				.removeClass('plantilla')
				.addClass('editando');

			$("#main .editando")
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
		var horarios = $('#horarios #frmHorario tr').not(":eq(0)");
		var url = urlPhp + "horarios/guardar.php";
		var data = new Array();
		 if(horario._validate()){
			$.each(horarios,function(){
				data.push({
					id:$(this).attr('id'),
					action: $(this).hasClass('nuevo')?'n':'e',
					agenda: $(this).find('.numero_agenda').val(),
					dia: $(this).find('.dia_semana').val(),
					ini: $(this).find('.hora_inicio').val(),
					fin: $(this).find('.hora_fin').val()
				})
			})

			$.ajax({
				type:"GET",
				data:{data : data},
				url: url,
				dataType: 'json'
			})
				.done(function(r,s){
					if(r.success)
						location.reload();
					else	
						notify.error('No se pudo guardar el horario!!')
					
					typeof callback == "function" && callback();
				})
				.fail(function(rsp){echo("fail =>"+rsp.sql);})
				.always(btn.load.hide);
		 }else{
			 notify.error('Debe de completar todos los campos.','Validar formulario');
			 btn.load.hide();
		 }
	},
	add: function(){
		var dia_semana = $('#horarios .template .dia_semana');
		var numero_agenda  = $('#horarios .template .numero_agenda');
		var nuevo_id = $('#horarios tr').length;
		$('#horarios .template')
			.clone()
			.removeClass('template')
			.attr('id',nuevo_id)
			.addClass('nuevo')
			.find(':checkbox').val(nuevo_id).end()
			.find('.hora_inicio').val('').end()
			.find('.hora_fin').val('').end()
			.find('.dia_semana').val($('option:first', dia_semana).val()).end()
			.find('.numero_agenda').val($('option:first', numero_agenda).val()).end()
			.appendTo('#horarios table')
	},
	del: function(){
		var selects = $('#horarios #frmHorario input:checked');
		var url = "horarios/eliminar.php";
		var data =  new Array();
		
		$.each(selects ,function(){
			data.push($(this).val());
		})
		var jsonString = JSON.stringify(data);
		
		$.getJSON(url,{ id : data },function(r){
			if(r.success){
				$.each(selects,function(){
					$(this).parents('tr').fadeOut();
				})
			}
		})
	},
	_validate: function(){
		var $time = $('#horarios #frmHorario .time');
		var return_function = true;
		$.each($time,function(){
			if ($(this).val() == '') return_function = false;
		})
		
		return return_function;
	},
}
var servicios = {
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
		var id = id_familia;
		var no_validate = no_validate || false;
		
		if (no_validate && $('#servicios .fam'+ id).is(':visible') ||$('#crearCita .fam'+ id).is(':visible')  ) return false ;
		var contenedor = $('.capasPrincipales:visible .contenedorServicios');
		var id = $.isEmpty(id)?1:id;

		contenedor
			.find('tbody tr').hide(function() {
				contenedor 
					.find('tbody .fam'+id).show()
			}).end()
		$('.menuServicios').each(function(){
			$(this)
				.find('.c3').removeClass('c3').end()
				.find('#'+id).addClass('c3');
		})

	},
	poppup:function(id){
		dialog.create('dlgServicios',function(){
			//clono el listado de familias desde el menu crearservicios.
			//AKI :: creando eliminanado y editando familias . cuando se crea nueva familia no se iserta en el dialog servicios
			if ($('#dlgServicios #lstFamilias select').length==0){
				var $lstFam = 
					$('#servicios .menuServicios #lstSerSelect')
						.clone(true,true)
						.removeClass('responsiveDesing_show')
						.appendTo('#dlgServicios #lstFamilias');
			}
			$("#frmEditarServicios #id").val(id);
			
			if (id!=0){ 
				//EDITANDO...
				var $this = $("#servicios #rowServicios"+id);

				var cod = $this.find("[name='cod']").text();
				var des = $this.find("[name='des']").text();
				var time = $this.find("[name='time']").text();
				var price = $this.find("[name='price']").data("value");
				var fam = $this.find("[name='fam']").data("value");

				$('#frmEditarServicios')
					.find('#codigo').val(cod).end()
					.find('#descripcion').val(des).end()
					.find('#tiempo').val(parseInt(time)).end()
					.find('#precio').val(price).end()
					.find('#familia').val(fam).end()
					.find('#eliminar').val('Eliminar');
			}else{ 
				//NUEVO....
				$('#dlgServicios #codigo').val($('#servicios #buscarTxt').val());
				var idCapa = $('#servicios .c3').attr('id');
				$('#dlgServicios #familia').val(idCapa);
				$('#dlgServicios #btnEliminar').val('Cancelar');
			}
			dialog.open('#dlgServicios',servicios.guardar,servicios.eliminar);
			if ($('#servicios #rowServicios'+ id ).hasClass('mostrar_baja')) {
				$('#dlgServicios .aceptar').html('Activar')
			}

		});
	},
	guardar: function (){
		var validate  = btn.load.show($('#dlgServicios .aceptar'),false);
		var idFrm = $('#dlgServicios form').attr('id') ;
		if(servicios.validate.form()){
			var id= $('#frmEditarServicios #id').val().replace(/\D/g,' ').trim();

			var data = $('#frmEditarServicios').serialize();
			var url = urlPhp+'servicios/guardar.php';

			$.ajax({
				type: "POST",
				dataType: "json",
				data: data,
				url: url,
				beforeSend: function(){if (id!=0)$("#servicios #rowServicios"+id).fadeTo("slow", 0.30)}
			})
			.done(function(rsp){
				if (rsp.success) {
	
					if (id==0){
						if (rsp.success) servicios.crear(rsp);
					}else{
						servicios.actualizar(rsp);
					}
					servicios.mostrar(rsp.familia);
					dialog.close('#dlgServicios');
				}else{
					notify.error('Codigo de servicio ocupado </br> Seleccione otro codigo distinto.', 'CODIGO OCUPADO') ;
				}
				$("#servicios #rowServicios"+id).fadeTo("slow", 1);
				btn.load.hide();
			}).fail(function(r){echo ("ERROR guardar servicios =>"+r)});

		}else{
			btn.load.hide();
		}
		
	},
	eliminar: function() {
		var id= $('#dlgServicios #id').val().trim();

		if (id!=0){
			if (confirm ("Deseas eliminar el servicio "+id+", " + $('#dlgServicios #codigo').val() + "?")) {
				$.ajax({
					type: "GET",
					dataType: "json",
					data: {id:id},
					url: urlPhp+'servicios/eliminar.php',
					beforeSend: function (){
						$("#servicios #rowServicios"+id).fadeTo("slow", 0.30);
					},
				})
				.done(function(){

					if (mns.success == true){
						var baja ; 

						if($('#chckOpUsersDel').is(':checked')){
							baja = 'mostrar_baja' ;
						}else{
							baja = 'ocultar_baja' ;
						}
						$("#servicios  #rowServicios"+id).addClass(baja) ;
						$("#crearCita  #rowServicios"+id).addClass(baja) ;
					}else{

						$("#servicios #rowServicios"+id).fadeTo("slow", 1) ;
						notify.error(mns.err,'ERROR') ; 
					}




					dialog.close('#dlgServicios');
				})
				.fail(function( jqXHR, textStatus, errorThrown){
					alert( jqXHR, textStatus, errorThrown)
					$("#servicios #rowServicios"+id).show("fast")})
			}
		}else{
			popup.close();
		}
	},
	actualizar: function(datos){

		$('#servicios #rowServicios'+datos.id)
			.css('class','fam'+datos.familia)
			.removeClass('mostrar_baja , ocultar_baja') 
			.attr('name',normalize(datos.codigo))
			.attr('familia',datos.familia)
			.attr('value',datos.id)
			.find(' td:nth-child(1)').attr('value',datos.id).end()
			.find(' td:nth-child(2)').html(datos.codigo).end()
			.find(' td:nth-child(3)').html(datos.descripcion).end()
			.find(' td:nth-child(4)').html(datos.tiempo).end()
		
		$('#crearCita #rowServicios'+datos.id)
			.removeClass('mostrar_baja , ocultar_baja') 
			.css('class','fam'+datos.familia)
			.find('label')
				.attr('for', datos.codigo)
				.text(datos.descripcion + ' (' + datos.tiempo +'min.)')
			.end()
			.find(':checkbox').attr({
				id : datos.codigo , 
				value : datos.id , 
				'data-time' : datos.tiempo , 
				'data-familia' : datos.familia ,
			})
		
	},
	crear: function(data){
		var url = urlPhp+'servicios/row.php';

		$.get(url,data,function(html){
			$('#servicios .tablas tbody')
				.append(html)
				.promise()
				.done(function(){
					notify.success('Se ha creado el servicio.','Nuevo servicio') ; 
					servicios.mostrar(data.familia,true)
				})
		
		},'html')
		
		if (!$.isEmpty($('#crearCita').html())){
			url = urlPhp+'crearCita/rowServicios.php' ; 
			
			$.get(url,data,function(html){
				$('#crearCita .contenedorServicios tbody')
					.append(html)
			},'html')			
		}

	},
	validate : {
		form : function () {  
			var nombre = $('#dlgServicios #codigo').val(); 

			if ($.isEmpty(nombre)){
				notify.error('El campo del codigo no puede estar vacio.','ERROR CAMPO VACIO!')
				return false ;
			}else {
				return servicios.validate.name(nombre) ;
			}
		},
		name : function (name) {
			var idName = $('#dlgServicios #id').val() ;
			var obj = $('#servicios #' +  normalize(name) ) ;

			if($('#servicios #' +  normalize(name) ).length == 0){
				return true ;
			}else{
				if (obj.parents('tr').attr('id') != 'rowServicios'+idName){
					notify.error('El codigo esta en uso.','Error crear servicio')  ;
					return false ;
				}else{
					return true ;
				}
			}
		}
	}
}
var usuarios = {
	init : function () {
		usuarios.select('A') ;
	},
	eliminar: function (id, nombre,callback) {
		if ($('#usuarios #id').val()!=0){
			if (confirm ("Deseas eliminar el cliente "+ id +"," + nombre + "?")) {

				$.ajax({
					type: "GET",
					dataType: "json",
					data: {id:id},
					url: urlPhp+'usuarios/eliminar.php',
					beforeSend: function (){
						$("#usuarios #rowUsuarios"+id).fadeTo("slow", 0.30);
					},
				})
				.done(function(){
					$("#usuarios #rowUsuarios"+id).addClass('ocultar_baja').fadeTo('fast',1);
					$('#lstClientes [data-id="'+normalize(nombre)+'"]').remove();
					notify.alert('El usuario ha sido eliminado con éxito.','Usuario eliminado!!')
				})
				.fail(function(){
					$("#usuarios #rowUsuarios"+id).show("fast");
					notify.error("¡¡No se pudo borrar el registro!!",'Error!');
				})

			}
		}
		
		popup.close();
	},
	guardar: function (idUsuario,nombreUsuario,callback){
		btn.load.show($('#dlgUsuarios .aceptar',false));

		
		if (!usuarios.validate.form()){
			btn.load.hide();
			return false 
		};
			var id= idUsuario||$('#dlgUsuarios #id').val();
			var data = $.isEmpty(nombreUsuario)
				?$("#frmUsuarios").serialize()
				:{nombre:nombreUsuario};

			$.ajax({
				type: "POST",
				dataType: "json",
				data: data,
				url: urlPhp+'usuarios/guardar.php',
			})
			.done(function(rsp){
				var $this  =$('#frmUsuarios')
				var frm = $.serializeForm('frmUsuarios');
				letra = frm.nombre[0];
				var chckEmail =frm.email==""?'No':'Si';
				var chckObs = frm.obs==""?'No':'Si';
				var admin = (frm.admin)?1:0;
				var activa = (frm.activa)?1:0;
					if (id==0){ 
						//NUEVO ...
						$.get('usuarios/row.php',{
							id : rsp.id, 
							nombre : frm.nombre , 
							email : frm.email , 
							tel : frm.tel , 
							admin : admin , 
							obs : frm.obs , 			
							activa : activa , 
							
						},function(html){
							$('#usuarios .tablas').prepend(html);
							$('#lstClientes')
								.append('<option data-id="'+normalize(frm.nombre)+'" value = "' + frm.nombre + '">'+rsp.id+'</option>')	
							notify.success('Usuario guardado con éxito!.','Nuevo usuario')
						})
					}else{ 
						//EDITANDO....
						$('#rowUsuarios'+id)
							.find(' td:nth-child(3)')
								.html(frm.nombre)
								.data('value',frm.nombre)
							.end()
							.find(' td:nth-child(4)').html(frm.tel).end()
							.find(' td:nth-child(5)')
								.html(chckEmail)
								.data('value',frm.email)
							.end()
							.find(' td:nth-child(6)')
								.html(chckObs)
								.data('value',frm.obs);
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
							$('#lstClientes [data-id="'+normalize(frm.nombre)+'"]').remove();
						}else{
							$("#rowUsuarios"+frm.id)
								.removeClass('mostrar_baja ocultar_baja')
								.fadeTo("slow", 1);
							$('#lstClientes')
								.append('<option data-id="'+normalize(frm.nombre)+'" value = ' + frm.nombre+  '>'+frm.id+'</option>')
						}	
						notify.success('Usuario guardado con éxito!.','Usuario editado')						
					}
				btn.load.reset();
				popup.close();
				usuarios.select(letra);
				
				btn.load.hide();
				typeof callback == "function" && callback();
			})
			.fail(function( jqXHR, textStatus, errorThrown ){alert( jqXHR + ' , '  +  textStatus + ' , ' +  errorThrown )})
	
	},
	dialog: function (id){
		dialog.create('dlgUsuarios',null,function(){
			$('#dlgUsuarios').find('#id').val(id)
					
				if (id!=0){
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
			dialog.open('#dlgUsuarios',usuarios.guardar,function(){
				usuarios.eliminar($('#dlgUsuarios #id').val(),$('#dlgUsuarios #nombre').val())
			})
		})		
	},
	historial: function ($this){
    	var id =$this.parent().parent().data('value');  
		var url = urlPhp+'usuarios/historial.php';
		$.getJSON(url,{id:id},function(data){
			dialog.create('dlgHistorial',function(){
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
				dialog.open('#dlgHistorial');
			});
		})
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
			var value = $('#dlgUsuarios	#nombre').val() ;
			if ($.isEmpty(value)){
				
				notify.error('El campo nombre no puede estar vacio.','Error crear usuario')  ;
				return false ;

			}else{

				return usuarios.validate.name(value) ;
				
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
$(function(){

	var ancho = $('#main th.aling-center').width()

	$('.lbl').width(ancho-18)
	$('body').on('click',".idDateAction",function(){
		if(!$(this).data('disabled')) sincronizar($(this).data('action'));
	})
	$('.tabcontrol').tabcontrol();

	main.lbl.color()
	main.lbl.draggable()
	main.lbl.droppable()

	var widht = $('#main').css('widht') / ($('#main thead th').length) - 1	;
	var editarObs = "";
	$('html')
		.on('click','.close',function(e){popup.close()})
		.on('change','input',function(){$(this).removeClass('input-error')})
		.on('click','.dialog-close-button',function(){
			dialog.open($(this).parents('.dialog:first'));
		})
		.on('change','#lstSerSelect',function(){
				var id = $(this).val();
				// servicios.mostrar(id);
				$('#lstSerSelect').each(function(){
					$(this).find('option[value='+id+']').attr('selected','selected');
				})
			})

	$('#btnContacto').click(function(){
		if($('#mnuContacto').is(':visible'))
			$('#mnuContacto').hide('slide',{ direction: 'right' });
		else
			$('#mnuContacto').show('slide',{ direction: 'right' });

	})
	$('#frmContact button')
		.click(function(event){
			var $this = $(this) ;
			event.preventDefault();
			var data = $("#frmContact").serialize();
			var url = urlPhp + "../../php/libs/contacto.php";
			$.post(url,data,function(){
				btn.load.hide();
			})
		});

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
		.on('click','.hora',function(){crearCita.dialog()})
		.on('click','.siguiente',function(e){crearCita.stepper($('div [id^="stepper"]:visible').data('value') + 1);})
		.on('blur','#cliente',crearCita.validate.name)
		.on("swipeleft",'.tablas');

	$('#familias')
		.on('click','table .icon-edit',function(){
			familias.mostrarPoppup($(this).attr('value'));
		})

	$('#general')
		.on('click','#btnCambiarPass',function(){
			dialog.create('dlgCambiarPass',null,function(){
				dialog.open('#dlgCambiarPass',config.pass)
			})
		})

	$('#main')
		.on('click','.lbl',function(){
			main.z_index +=  1 
			$(this).css({'z-index': main.z_index })
				
		})
		.on('click','.row_1',function(){
			
			if ($(this).hasClass('initial')){

				$(this)
					.removeClass('initial') 
			    	.animate({	height: '2.3rem'});	

			} else{

				$(this)
					.addClass('initial') 
					.animate({height: $(this).get(0).scrollHeight});	
			
			}  

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
		.on('click','.icon-attention',function(e){main.citasSup($(this));e.stopPropagation()})
		.on('click','.edit', function(e){
			e.stopPropagation() 
			main.edit($(this).parents('.lbl').attr('id'))
		})
		.on('click','.cita',function(e){
			$(this).parent()
				.find('.note')
					.addClass('show')
					.find('input')
						.focus();

		})
		.on('click','.lbl .icon-trash',function(e){
			e.stopPropagation();
			main.del($(this).parents('.lbl').attr('id'))
		})
		.on('change','#selectTablasEncabezado',function(){main.responsive($(this))})
		.find('.tile').css('width',widht+'%').end()
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
		.find('[name="menu[]"]').click(function(){
			var capa = $(this).data('capa') ;
			if (capa == 'main'){
				mostrarCapa('main' ,  true ) 
			}else{
				mostrarCapa($(this).data('capa'));
			}
			$('.app-bar-pullmenu ').hide('blind');
		})

	$("#notas")
		.find('#eliminar').click(function(){eliminarNota})
		.find('#frmNotas').submit(function(e){
			e.preventDefault();
			main.guardarNotas();
		})

	$("#festivos")
		.on('click',"[name='eliminar[]']",function(){festivo.eliminar($(this))})

	$('#agendas')
		.on('#cancelar',function(){popup.close()})
		.on('submit','#frmAg',function(e){
			e.preventDefault();
			guardarAgenda()
		})
		.on('change','input',function(){
			agendas.change =  true;
		})

	$('#servicios')
		.on('click','a',function(){servicios.mostrar($(this).attr('id'),$('#servicios'))})
		.on('change','.lstServicios ',function(){servicios.mostrar($(this).val())})
		.on('change','#familia',function(){familias.change = true})
		.on( "click", "[name*='editar']", function(e){servicios.poppup($(this).attr('value'))})
		.find('option:first-child').attr('selected','selected');
		
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

		//funciones
		cargarDatepicker();
		colorearMenuDiasSemana();



})
