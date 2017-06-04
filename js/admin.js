if ($('#navbar').is(':hidden')) $('#navbar').show('blind');
var urlPhp = "../../php/admin/"; 
var admin = true;
var HORARIOS = document.horarios;
var FESTIVOS = document.festivos;
//var hora = 0; 

function sincronizar(date,dias,callback){

	var fecha = date||Fecha.general;
	
	if (dias)
		fecha =  Fecha.calcular(dias, fecha);
	else
		dias = 0;
	
	Fecha.general = Fecha.sql(fecha);
	Fecha.id = Fecha.number(Fecha.general);
	

	colorearMenuDiasSemana();

	//sincronizo horarios para hacer consulta en crear Cita
	main.sincronizar(dias);	
	crearCita.sincronizar(dias);
	typeof callback == "function" && callback();
	

	$('.datepicker').each(function(){
		$(this)
			.val(Fecha.print(fecha))
			.datepicker("setDate",Fecha.print(fecha));
	})
}
function mostrarCapa(capa,callback){
	if($('#'+capa).is(':visible')) return false;
	
	if($('#'+capa).is(':empty')){
		$.get($('#'+capa).data('url'),function(html){
			$('#'+capa).append(html);
		},'html')
	}
	
	if($('#config').is(':visible')&&config.change) config.guardar();
	if($('#agendas').is(':visible')&&agendas.change) agendas.guardar();
	if($('#crearCita').is(':visible')) crearCita.reset();

	$('.capasPrincipales').hide();

	$('#'+capa).fadeIn();
	menu.status(capa);
	if(capa=='main') $('#'+Fecha.number(Fecha.general)).show();
	if(capa=='servicios') servicio.menuTamaño();
	resetBtnLoad();

	$('html,body').animate({scrollTop:0}, 500);

	typeof callback == "function" && callback();
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

		menu.disabled(add,reset,search,save,show,edit);

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
				menu.enabled(save)
				 break;
			case 'festivos':
				menu.enabled(save)
				 break;
		}

		$('#navbar').resize();
	},
	save:function (){
		var loadShow = function (){
			$('#btnSave')
				.find('.icon-floppy').hide().end()
				.find('.icon-load').css('display','inherit')
		}();
			switch($('.capasPrincipales:visible').attr('id')) {
			case 'config':
				config.guardar( );
				break;
			case 'horarios':
				horario.guardar( loadHide);
				break;
			case 'agendas':
				agendas.guardar( loadHide);
				break;
			case 'festivos':
				festivo.guardar(loadHide);
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
				usuario.poppup(0);
				break;
			case 'servicios':
				 servicio.poppup(0);
				break;
			case 'familias':
				familias.mostrarPoppup(-1);
				 break;
			case 'horarios':
				horario.add();
				break;
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
		$('#btnReset .icon-undo')
			.attr('class','icon-load animate-spin')
			.show()

		switch($('.capasPrincipales:visible').attr('id')) {
			case 'main':
				sincronizar(null,null,function(){
					$('#btnReset .icon-load ')
						.fadeOut(function(){
							$(this)
								.attr('class','icon-undo')
								.fadeIn()
								.css("display","inline-block")
						})
				});
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
					usuario.buscar($('#txtBuscar').val());
					break;
				case 'servicios':
					servicio.buscar();
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
}
var agendas = {
	change: false ,
	guardar: function (callback){
		$.ajax({
			type: "POST",
			dataType: "json",
			data: $('#agendas #frmAg').serialize(),
			url: urlPhp+'config/agendasGuardar.php'
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
	eliminar : function (e) {
		var id = $('#dlgFamilias #id').val();

		if (confirm ("Deseas eliminar la familia " + id + "?")) {
			$.ajax({
				type: "GET",
				data: {id:id},
				url: urlPhp + "familias/eliminar.php",
				dataType: "json",
				beforeSend: function(){if (id>=0)$("#rowFamilias"+id).fadeTo("slow", 0.30)}
			})
			.done(function(mns){
				if (mns.success==true){
					$("#familias #rowFamilias"+id).remove();
					$('#servicios #frmEditar #familia option[value="'+id+'"]').remove();
					$('.menuServicios').each(function(){
						$(this).find('.menu #'+id).remove()
					});
				}else{
					$("#familias #rowFamilias"+id).fadeTo("slow", 1);
					console.log("ERROR=>"+mns);
				}
				popup.close(id);
			}).fail(function(mns){
				console.log("ERROR =>"+mns);
				$("#familias #"+id).fadeTo("slow", 1);
			});

		}else{
			e.stopPropagation();
			resetBtnLoad();
		}

	},
	guardar :function (){
		var id = $('#dlgFamilias #id').val();
		$.ajax({
			type: "POST",
			dataType: "json",
			data: $("#frmEditarFamilia").serialize(),
			url: urlPhp+"familias/guardar.php",
			beforeSend: function(){if (id>=0)$("#rowFamilias"+id).fadeTo("slow", 0.30)}
		})
		.done(function(data){
			if (id>=0){
				 $('#familias #nombre'+id).html(data.nombre);
				var estado = (data.mostrar==1)?true:false;
				var $chck = $('#familias #chck'+id);
				$chck.prop("checked",estado);
				$('#servicios #frmEditar #familia option[value='+id+']').html(data.nombre);

				$('.menuServicios').each(function(){
					$(this).find('.lstMenu #'+id).html(data.nombre)
				});

			}else{
				var mostrar = (data.mostrar==1)?'checked':'';
				$("#familias table").append("\
					<tr id='rowFamilias"+data.id+"'>\
					<td><a name='editar[]' class= 'icon-edit x6' value="+data.id+"></a></td>\
					<td id='nombre"+data.id+"' class='nom'>"+data.nombre+"</td>\
					<td class='ico'>\
					<input type='checkbox' name = 'mostrar[]' id='chck"+data.id+" class='mostrar'\
					value="+data.id+" "+ mostrar + "></td></tr>")
				$('#servicios #frmEditar #familia').append("<option value="+data.id+">"+data.nombre+"</option>");
				$('.menuServicios')
					.find('#mainLstServicios').append("<a id="+data.id+">"+data.nombre+"</a>").end()
					.find('.lstServicios select').append("<option id="+data.id+" value="+data.id+">"+data.nombre+"</option>");
			}
			popup.close();
			crearCita.mostrar.familias(data);
			$("#rowFamilias"+id).fadeTo("fast", 1);
		})	.fail(function(){echo ("¡¡No se pudo guardar el registro!!");})
	},
	chckGuardar: function(id,mostrar){
		var url = urlPhp + "familias/familias.chckGuardar.php";

		$.ajax({
			type: "POST",
			dataType: "json",
			data: {id:id, mostrar:mostrar},
			url: url,
			beforeSend: function(){
				console.log ("envio..."+id);
			}
		}).done(function(mns){
		}).fail(function(mns){
			echo ("¡¡No se pudo editar el registro!!");
		})
	},
	mostrarPoppup: function (id){
		dialog.create('dlgFamilias',function(){
			if (id!=-1){
				$('#dlgFamilias #frmEditarFamilia')
					.find ('#id').val(id).end()
					.find("#nombre").val($('#familias #nombre'+id).html()).end()
					.find("#mostrar").attr('checked', $('#familias #chck'+id).prop('checked'));
			}else{
				$("#dlgFamilias #frmEditarFamilia #id").val(id);
			}
			dialog.open('#dlgFamilias',familias.guardar,familias.eliminar);
		});
	},
}
var crearCita ={
	idUser : function () {
		var cli = $('#crearCita #cliente').val();
		var  nombre = normalize(cli);
		return parseInt($('#lstClientes [value="'+cli+'"]').text())||0;
	}, 
	sincronizar: function(dias,callback){

		$('#crearCita #tablas table').removeClass('activa');
		if(!$('#crearCita #'+Fecha.id).length)
			crearCita.horas.iniciar();
		
		$('#crearCita #'+Fecha.id).addClass('activa');
	},
	servicios:function(callback){
		 	
		var contenedor = $('#crearCita .contenedorServicios');
		var familias = "";

		contenedor
			.html($('#servicios .menuServicios').clone())
			.append('<table class="datos"></table>');

		contenedor.find('table').html(familias);
		$('#servicios .datos tr').each(function(i,v){
			var $this = $(this);

			datos = {
				id: $this.attr('value'),
				codigo: $this.attr('name'),
				descripcion: $this.find('[name="des"]').html(),
				tiempo: $this.find('[name="time"]').html(),
				familia: $this.attr('familia'),
			}
			//crearCita.mostrar.servicios(datos);
		})
		var fam = contenedor.find('.lstServicios a:first').attr('id');

		//servicio.mostrar(fam);

		typeof callback == "function" && callback();

	},
	cliente: function (){
		var url = urlPhp + 'usuarios/guardar.php';
		var nombre = $('#crearCita #cliente').val();
		usuario.guardar(0,nombre,btnLoad.hide);
	},
	dialog: function (){
		dialog.create('dlgGuardar',function(){
			var str_servicios ="";
			$('#crearCita [name="servicios[]"]:checked')
				.each(function(){
					str_servicios += $(this).attr('id') + ", ";
				})
			str_servicios = str_servicios.slice(0,-2);

			var hora = $('#crearCita [name="hora[]"]:checked').parent().find('.lblHoras').html();
			$('#dlgGuardar')
				.find('#lblHora').html(hora).end()
				.find('#lblFecha')
					.html(Fecha.print(Fecha.general)).end()
				.find('#lblCliente').html($('#crearCita #cliente').val()).end()
				.find('#lblSer').html(str_servicios)
			dialog.open('#dlgGuardar',crearCita.guardar)
		})
	},
	guardar: function(){

		if(crearCita.validate.form()){
			var url = urlPhp + 'crearCita/guardar.php';
			var data = $('#crearCita #frmCrearCita').serialize()+"&fecha="+Fecha.general;

			$.post(url,data,function( rsp ){
				if(rsp.ocupado){
					notify.error('Ya no se puede reservar más la cita. <br> Cambie la hora seleccionada.' , ' Hora ocupada' );
				}else{	
				//Generar un arreglo para pintar lbl
				//index idCita
				//C.Id, D.IdCita,  D.Fecha , C.Hora ,D.IdUsuario, U.Nombre, A.Id AS IdCodigo, A.Codigo, A.Tiempo , D.Agenda,  D.Obs 

					var servicios = $('#frmCrearCita .contenedorServicios :checked') ; 					
					var hora = parseInt($('#frmCrearCita .tblHoras input:checked').val()) ;
					
					var nombre = $('#frmCrearCita #cliente').val() ;
					var idUser = crearCita.idUser();
					var agenda = $('#frmCrearCita #selAgendas input:checked').val() ;
					var nota  = $('#frmCrearCita #crearCitaNota').val() ;
					var arr_datos = new Array();
					
			
					$.each(servicios,function( index , $this ){
						var time = Math.ceil(parseInt($(this).data('time'))/15) ; 

						for(let i = 0 ; i <= time ; i++){	

							arr_datos = [rsp.id[index], rsp.idCita , Fecha.general , hora , idUser , nombre , $this.value , $this.id , $(this).data('time') , agenda , nota ] ;
							hora += 900;
							main.lbl.crear(arr_datos) ;
						}	
					})
						
					mostrarCapa('main');
						
				}
				dialog.close('#dlgGuardar');
			},'json')
			.fail(function( jqXHR, textStatus, errorThrown){
				echo(jqXHR);
				echo(textStatus);
				echo(errorThrown);
				return false;
			})
			
		}else{
			notify.error('Complete todos los datos');
			return false;
		}

	},
	horas: {
		iniciar: function(){
//AKI :  crear dias cuando no estan creadas en el crearCitas horas		
		
			cargarDatepicker();
			$('#main .dia').each(function(index , table){
				var self = {
					obj : $('#crearCita #'+$(this).attr('id')),
					id : $(this).attr('id')
				}
				if (Fecha.restar(self.id)>=0 && !self.obj.length) 
					crearCita.horas.crear($(this));
			})
		},

		crear: function ($this, callback){
			var contenedor = $('#crearCita .tblHoras');
			
			let table = 
			$('<table>', {
				id : $this.attr('id'),
			}).appendTo(contenedor);
			
			$this.find('.hora') 
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
			 crearCita.horas.pintar($this.attr('id')); 
//AKI: hay que quitarlo de aqui y mandarlo a la visuañizacion de las horas
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
		hora =0 ;
		resetBtnLoad();
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
			else if(index==1 &&crearCita.validate.name())_slider()
			else if(index==2&&crearCita.validate.service()){
				if(crearCita.validate.name())_slider(function(){
					if (hora!=0){
						var f = formatoFecha(Fecha.general,'number');
						$('#crearCita #'+hora).attr('checked',true);
						$('#crearCita #lblHora').html(ARRAYHORAS[parseInt(hora)])
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
			var cliente = $this.val();

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
	cambiarContraseña: 	function (){ 
			var $newPass = $('#dlgCambiarPass #newPass');
			var $repeatPass = $('#dlgCambiarPass #repeatPass');
			var url =  urlPhp + 'config/cambiarPass.php';
			var data = {
				oldPass : $('#dlgCambiarPass #oldPass').val(),
				newPass: $('#dlgCambiarPass #pass').val()
			}
			if(validar.pass.estado){
				$.post(url,data,function(r){
					if(r.success){
						$.Notify({
							type: 'success',
							caption: 'Guardada',
							content: 'Contraseña cambiada',
							icon: 'icon-floppy'
						})
						$('#dlgCambiarPass')[0].reset();
						dialog.close('#dialogs #dlgCambiarPass');					
					}else{
							$.Notify({
								type: 'alert',
								caption: '¡Error!',
								content: r.respond,
								icon: 'icon-cross'
							});				
					}
					btnLoad.hide();
				},'json')
			}else{
				btnLoad.status=false;
			}
		},
	guardar: function (callback){
			var formData = new FormData($("#config form")[0]);
			var std = $('#config #frmConfig #showInactivas').is(':checked');
			var ruta = "../../php/admin/config/guardar.php";

			main.inactivas(std);

			$.ajax({
				url: ruta,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
			})
			.done(function(r){
				var rsp = r.err==3?"Archivo demasiado grande":'<img src="../arch/logo.png">';

				$("#config #respuestaLogo").html(rsp);

				r.err == 0?	ocation.reload(true):loadHide();

				typeof callback == "function" && callback();
			})
			.fail(function(){

				typeof callback == "function" && callback();
			})
			config.change = false;
		},
}
var general = {
	guardar: function ($this){
		var  data = $this.serialize();
		var url  = urlPhp+'general/guardar.php';
		$.post(url,data, function(r) {
				$.Notify({
					caption: 'Configuración',
					content: 'Guardada',
					type: 'success',
					icon: 'icon-floppy'
				})
			resetBtnLoad();
		},'json')
		.fail(function(r){echo("ERROR guardando configuración")})
		.always(btnLoad.hide)
	}
}
var festivo = {
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
	guardar:	function (){
		var data = $('#festivos form').serialize();
		var url = urlPhp + 'festivos/guardar.php';
		var fila = $('#tblFestivos tr:first').clone();
		var nombre =$('#nuevo [name="nombre[]"]').val();
		var fecha =$('#nuevo #dpFestivos').val();
		
		
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
							<td  class="aling-left"><span name="nombre[]">'+nombre+'</span></td>\
							<td> <span  name="mes[]" >'+Fecha.print(fecha)+'</span></td>\
						</tr>\
					').end()
						.find('#frmNuevo')[0].reset();
					hideShow('#nuevo .icon-plus','#nuevo .icon-load')
					
					var url = urlPhp + 'config/festivosCns.php';
					$.getJSON(url,function(d){FESTIVOS=d})
					
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
				.always(btnLoad.hide);
		 }else{
			 notify.error('Debe de completar todos los campos.','Validar formulario');
			 btnLoad.hide();
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
var main ={
	sincronizar: function (dir,callback){

		var idFecha=Fecha.number(Fecha.general);
		var diaFestivo = $.inArray(Fecha.md(Fecha.general),FESTIVOS)!=-1;
		
		(diaFestivo)?$('.datepicker').addClass('c-red'):$('.datepicker').removeClass('c-red');

		$('#main #'+idFecha).length>0
			?main.check(false,_finCarga)
			:main.crearDias(_finCarga);

		//no lo meto en fin de carga para avanzar mas rapido
		if (idFecha != $('#main .dia.activa').attr('id'))
			_sliderDias(idFecha,dir)
		//**

		function _finCarga(){
			main.lbl.color($('.editando'),function(){
				$('#main .editando').removeClass('editando');
				typeof callback == "function" && callback();
			})
		}

		function _sliderDias(idFecha,dir,callback){
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
							typeof callback == "function" && callback();
						});
				})

		}
	},
	crearDias: function(callback){

		var mD = ($('body').data('margenDias'))/2;
		var fechaIni = calcularFecha(-1*mD,Fecha.general);
		var fecha = fecha||Fecha.general;
		var dias = $('#main .cuerpo .dia');
		var ids = new Array();
		
		$.each(dias,function(){
			ids.push($(this).attr('id'));
		})

		$.ajax({
			type:"get",
			url: urlPhp+'agendas/cView.php',
			dataType: 'html',
			data: {
					f : Fecha.general ,
					ids :JSON.stringify( ids ),
					},
			cache: false
		})
		.done(function(html){
			$('#main .cuerpo').append(html);
			//if (!$.isEmpty(r.ins)) main.lbl.crear(r.ins);

			typeof callback == "function" && callback();
		}).fail(function(r,status){console.log("Fallo refrescando=>"+status)});
		
	},
	refresh : function(arr_id_insert , arr_id_del , arr_idUser ){

		var url = "agendas/refreshCns.php";	
		var arr_data = {
			ins : arr_id_insert,
			del : arr_id_del,  
		};
		$.getJSON(url,arr_data,function(data){ 
			if (!$.isEmpty(data)){
				if (!$.isEmpty(data.ins)){
					
					$.each(data.ins,function(index,value){
						
						main.lbl.crear(value);
						
						notify.success('El cliente ' + arr_idUser[index] + ',<br> ha creado la cita ' + index ,'Guardado',true);
						
					})
					
				};
				
				if (!$.isEmpty(data.del)){
					
					$.each(data.del,function(index,value){

						main.lbl.eliminar(index,value);

						notify.error('El cliente ' + arr_idUser[index] + ',<br> ha eliminado la cita ' + index,'Eliminada',true);
						
					})
					
				} 
				main.lbl.color();
			}
		});
	},
	check: function(callback){
		//var idFecha = Fecha.number(Fecha.general);
		//$('#'+idFecha).addClass('editando')
		//var $celdas = $('.editando .celda');

		if(xhr && xhr.readystatus != 4) { xhr.abort();}

		xhr =  $.ajax({
			type:"get",
			url: urlPhp+'agendas/refreshCheck.php',
			dataType: 'json',
			
		})
		.done(function(data){
	
			//ASSOC
			//id idCita status
			
			if(!$.isEmpty(data)){
				var arr_id_insert  = new Array();
				var arr_id_del  = new Array();
				var arr_id_user  = new Array();
				
				$.each(data,function(i,data){
					
					arr_id_user[data.idCita] = data.idUser;
					
					if (data.status == 1){
				
						//ha creado cita 
						arr_id_insert.push(data.idCita);
						
					}else{
						
						//ha eliminado la cita
						arr_id_del.push(data.idCita);
						
					}
				})
	
				if (!$.isEmpty(arr_id_insert) || !$.isEmpty(arr_id_del))
					main.refresh( arr_id_insert , arr_id_del , arr_id_user); 

			}
			typeof callback == "function" && callback();
		})
		
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
	eliminar: function($this){
		dialog.create('dlgEliminarCita',function(){
			var idCita = $this.parents('table:first').attr('idcita').replace(/\D/g,' ');

			$('#dlgEliminarCita')
				.data('idCita',idCita)
				.on('click','#frmDelCita input:checkbox',function(){
					$('#desMarkChckSer').prop('checked',false);
				})
				.find('input:checkbox').prop('checked',true);

			var cod = new Array;
			var id = new Array;

			$('#main .ic'+idCita).each(function(){
					 cod.push($(this).attr('codigo'));
					 id.push($(this).attr('idCodigo'));
			})
			cod = $.unique(cod)
			id = $.unique(id)
			$('#dialogs #frmDelCita').empty();

			for(let i = 0; i < cod.length;i++){
				$('#dialogs #chckSer').clone()
					.attr('id','')
					.find('#desMarkChckSer').attr('id','').end()
					.find('input')
						.attr('value',id[i])
						.attr('id',id[i]+cod[i])
					.end()
					.find('label .txt').html(cod[i]).end()
					.appendTo('#dialogs #frmDelCita')
			}


			$('#dialogs #dlgEliminarCita')
				.on('click','#desMarkChckSer',function(){
					var estado = $(this).prop("checked");
					$('#frmDelCita input').each(function(){
						$(this).prop('checked',estado)
					})
				})
				.find('#lblCita').html(idCita);

			dialog.open('#dlgEliminarCita',_ok,_cancel);

			$('#main #lblServicio').html($this.parents('tr').attr('codigo'));

			dialog.open('#dlgEliminarCita',familias.guardar,familias.eliminar);
		});

		function _ok(){
			var idCita = 	$('#dlgEliminarCita').data('idCita')
			var frm =$.param( $('#frmDelCita input:checked'))+"&idCita="+idCita+'&f='+Fecha.general;
			var url = urlPhp+'agendas/citaEliminar.php';
			var chck = new Array;
			$('#frmDelCita input:checked').each(function (){
				chck.push($(this).val())
			});

			$.ajax({
				type: "GET",
				dataType: "json",
				url: url,
				data:frm,
			})
			.done(function(r){
				if ($.isEmpty(r.err)){
					main.lbl.eliminar(idCita, chck);
				}
			})
			.fail(function(r){echo("ERROR citaEliminar =>");echo(r)})
			.always(function(){popup.close('dlgEliminarCita')})
		}
		function _cancel(){
			dialog.close('.dialog',function(){
				$('#lstChckSer').empty();
				$('#dlgEliminarCita').removeData('idCita')
			});
		}
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
			if($('#main .cuerpo').data('estado-inactivas')==0){
				$('#main .cuerpo').data('estado-inactivas',1)
				$('#btnShow')
					.find('.menulbl').html('Ocultar').end()
					.find('.on').show().end()
					.find('.off').hide().end()
				$('#main .fuera_horario').parent().removeClass('disabled');
			}else{
				$('#main .cuerpo').data('estado-inactivas',0)
				$('#btnShow')
					.find('.menulbl').html('Mostrar').end()
					.find('.off').show().end()
					.find('.on').hide().end()
				$('#main .fuera_horario').parent().addClass('disabled');
			}
	},
	lbl:{
		crear: function(datos,todaCita,callback){
			//C.Id, D.IdCita,  D.Fecha , C.Hora ,D.IdUsuario, U.Nombre, A.Id AS IdCodigo, A.Codigo, A.Tiempo , D.Agenda,  D.Obs 
			
			if($.isEmpty(datos)) return false  ;

			if ($.isArray(datos[0])){
				for(let i = 0; i<datos.length;i++){
					_crear(datos[i]);
				}
			}else{
				_crear(datos);
			}

			function  _crear(data){
				var id = data[0];
				var idCita = data[1];
				var idFecha = Fecha.number(data[2]);
				var hora = data[3];
				var idUsuario = data[4];
				var nombre = data[5];
				var idCodigo = data[6];
				var codigo = data[7];
				var agenda  = data[9];
				var obs = data[10];
				
				
			
				var attention = "<span class='icon-attention aling-right' title='¡ATENCION, CITAS SUPERPUESTAS!'></span>";
				var $celda  =$('#main #'+idFecha+' .h'+ hora+' .agenda'+agenda);
				var mostrarNotas = (!$.isEmpty(obs))?'show':'';				
	
				var servicio = '<table class="cita"  \
											idcita=' + idCita+' \
											codigo="'+codigo+'" \
											idcodigo="'+idCodigo+'" \
											idser = "'+id+'">';
				var tdCodigo = "<td><span class='icon-angle-right'></span> <span class='"+codigo+"'>"+codigo+"</span></td>";
				
					if($('#' + idFecha + ' .ic'+idCita).length==0||todaCita){
						
						servicio += "<tr>";
							servicio += "<td>";
								servicio += "<span class='icon-user-1'>"+nombre+"</span>";
								servicio += attention;
								servicio += "<span class='icon-cancel aling-right '></span>";
								servicio += "<span class='aling-right numidcita'>"+idCita+"</span>";
							servicio += "</td>";
							servicio += "<td class='note "+mostrarNotas+"'>";
								servicio += "<div class='iconClass-container icon-right'>";
									servicio +="<span class='icon-note'></span>";
									servicio += "<input type='text' value='"+obs+"'>";
									servicio +="<span class='iconClass-inside icon-load  animate-spin'></span>";
									servicio += "<span class='iconClass-inside icon-ok'></span>";
								servicio += "</div>";
							servicio += "</td>";
						servicio += tdCodigo;

					}else{
						
						servicio += ($('#' + idFecha + ' .ic'+idCita + ' .'+codigo).length <=0)?tdCodigo:"<td>"+attention+"</td><td></td><td></td>";

					}

					servicio += "</tr></table>";

					if($celda.find('.cita').length){
						
						if($celda.find('table').attr('idcita')!=idCita){
							$celda
								.append(servicio)
								.find('tr td:first-child .icon-attention').show().end()
								.find('table').addClass('hidden')
								.find(".icon-user-1").length
									?$celda.find(".icon-user-1").parents('table:first ').removeClass('hidden')
									:$celda.find('table:first-child').removeClass('hidden')
						 }

					}else{
						// cuando se hace referencia a tabla hay que tener encuenta que pueden ser varias
						$celda
							.hide()
							.html(servicio)	
							.fadeIn() 	
					}


					$celda.find('[idCita="'+idCita+'"]')
						.addClass(' ic'+idCita+' cod'+idCodigo+' ocupada')	
						//soluciono problema color en las celdas vacias


					
				main.lbl.color();
				typeof callback == "function" && callback();

			}
		},
		eliminar: function(idCita,idCodigos,callback){

			if (typeof (idCodigos)=="array" || typeof (idCodigos)=="object"){

				var  idCod = $.unique(idCodigos);
				for(let i = 0; i<idCod.length; i++){
					_eliminar(idCod[i]);
				}
				
			}else{
				_eliminar (idCodigos);
			}

			function _eliminar (id){

				var table = $('#main .ic'+idCita+'.cod'+id);
				var celda = table.parent();

				table.each(function(){
					table
						.hide('explode',750)
						.remove()
					celda
						.removeClass('color1 color2 color3 color-red')
						.find('.icon-attention')
							.each(function(){
								$(this).hide('explode').removeClass('show')
							})

					if(celda.find('table').length>0){
						table = celda.find('table');
						
						table
							.show('fade',750)
							.find('.icon-attention')
								.hide()
					}
				})
				
			}
			main.lbl.color();
		},
		color: function(callback){	
			var dias= $('.dia');
			var agendas = $('#main .cabecera').data('agendas');
			var idsCitas = new Array;

			dias.each(function(){
				var celdas = $(this).find('.celda');
			
				$(this)
					.find('color1').removeClass('color1').end()
					.find('color2').removeClass('color2').end()
					.find('color3').removeClass('color3').end()
					.find('color-red').removeClass('color-red')
					var color = 'color1';

				for(let a = 1; a <= agendas; a++){
					
					let idCita = 0;
					$(this).find('.agenda'+a+' .cita')
						.each(function(){
							if (idCita != $(this).attr('idcita')){
								color = color == 'color1'?'color2':'color1';
							}

							$(this).data('color',color)
							let celda = $(this).parent();
							if (!celda.is('.color1, .color2, .color3, .color-red'))
									celda.addClass(color);

							idCita = $(this).attr('idcita');
						})
				}
			})
			typeof callback == "function" && callback();
		}
	},
}
var servicio = {
	buscar: function(){
		$('#servicios .capaServicios').fadeIn();
		$("#servicios tr").fadeOut();
		$("#servicios .encabezado:first").fadeIn();
		var txt = normalize($('#txtBuscar').val());
		$("[name*='"+txt+"']").fadeIn();
	},
	menuTamaño: function(){
		var height = parseInt($('#servicios .cabecera').css('height'));
	},
	mostrar: function(id) {
		var section = $('.capasPrincipales:visible');
		var contenedor = section.find('.contenedorServicios');
		var id = $.isEmpty(id)?1:id;

		contenedor
			.find('tbody tr').fadeOut().end()
			.find('.disabled').removeClass('disabled').end()
			.find('tbody .fam'+id).fadeIn().end()
			.find('.c3').removeClass('c3').end()
			.find('#'+id).addClass('c3');

	},
	poppup:function(id){
		dialog.create('dlgServicios',function(){
			//clono el listado de familias desde el menu crearServicio.
			if ($('#dlgServicios #lstFamilias select').length==0){
				var $lstFam = 
					$('#crearCita .menuServicios #lstSerSelect')
						.clone()
						.removeClass('responsiveDesing_show')
						.appendTo('#dlgServicios #lstFamilias');
			}
			$("#frmEditarServicios #id").val('Id servicio: '+id);
			
			if (id!=0){ 
				//EDITANDO...
				var $this = $("#servicios #rowServicios"+id);

				var cod = $this.find("[name='cod']").text();
				var des = $this.find("[name='des']").text();
				var time = $this.find("[name='time']").text();
				var price = $this.find("[name='price']").data("value");
				var fam = $this.find("[name='fam']").data("value");

				$("#frmEditarServicios #codigo").val(cod);
				$("#frmEditarServicios #descripcion").val(des);
				$("#frmEditarServicios #tiempo").val(parseInt(time));
				$("#frmEditarServicios #precio").val(price);
				$("#frmEditarServicios #familia").val(fam);
				$('#frmEditarServicios #eliminar').val('Eliminar');
			}else{ 
				//NUEVO....
				$('#ppServicios #codigo').val($('#servicios #buscarTxt').val());
				var idCapa = $('#servicios .c3').attr('id');
				$('#ppServicios #familia').val(idCapa);
				$('#ppServicios #btnEliminar').val('Cancelar');
			}
			dialog.open('#dlgServicios',servicio.guardar,servicio.eliminar);
		});
	},
	guardar: function (){
			var id= $('#frmEditarServicios #id').val();
			var data = $('#frmEditarServicios').serialize();
			var url = urlPhp+'servicios/guardar.php';
			id = id.replace(/\D/g,' ').trim();

			$.ajax({
				type: "POST",
				dataType: "json",
				data: data,
				url: url,
				beforeSend: function(){if (id!=0)$("#rowServicios"+id).fadeTo("slow", 0.30)}
			})
			.done(function(rsp){
				if (id==0){
					servicio.crear(rsp);
				}else{
					servicio.actualizar(rsp);
				}
				servicio.mostrar(rsp.familia);
				popup.close();
			}).fail(function(r){echo ("ERROR guardar servicios =>"+r)});
	},
	eliminar: function() {
		var id= ($('#ppServicios #id').val());
		id = id.replace(/\D/g,' ').trim();

		if (id!=0){
			if (confirm ("Deseas eliminar el servicio "+id+", " + $('#ppServicios #codigo').val() + "?")) {

				$.ajax({
					type: "GET",
					dataType: "json",
					data: {id:id},
					url: urlPhp+'servicios/eliminar.php',
					beforeSend: function (){
						$("#servicios #rowServicios"+id).fadeTo("slow", 0.30);
						popup.close();
					},
				})
				.done(function(){
					$("#servicios #rowServicios"+id).fadeTo("slow", 0,function(){
						$("#crearCita #rowServicios"+id).remove()
						$("#servicios #rowServicios"+id).remove()
					});
				})
				.fail(function(){$("#servicios #rowServicios"+id).show("fast")})
			}else{popup.close();}
		}else{
			popup.close();
		}
	},
	actualizar: function(datos){
		$('#servicios #rowServicios'+datos.id)
			.css('class','fam'+datos.familia)
			.attr('name',normalize(datos.codigo))
			.attr('familia',datos.familia)
			.attr('value',datos.id)
			.find(' td:nth-child(1)').attr('value',datos.id).end()
			.find(' td:nth-child(2)').html(datos.codigo).end()
			.find(' td:nth-child(3)').html(datos.descripcion).end()
			.find(' td:nth-child(4)').html(datos.tiempo).end()
			.find(' td:nth-child(4)').attr('value',datos.precio).end()
			.fadeTo("fast", 1);
		$('#crearCita #rowServicios'+datos.id)

	},
	crear: function(data){
		$('#servicios .datos')
			.prepend("\
				<tr id='rowServicios"+data.id+"' \
				class='fam"+data.familia+"' \
				name='"+normalize(data.codigo)+"' \
				familia = "+data.familia+" \
				value="+ data.id+">\
					<td class='w1'><a name='editar[]' class='icon-edit x6' value='"+data.id+"'></a></td>\
					<td name='cod' class='aling-left w2'>"+data.codigo+"</td>\
					<td name='des' class='nom'>"+data.descripcion+"</td>\
					<td name='time' class ='w1'>"+data.tiempo+"</td>\
					<td name='price' class='hidden' data-value='"+data.precio+"'></td>\
				</tr>");
		crearCita.mostrar.servicios(data);

	}
}
var usuario = {
	eliminar: function (id, nombre,callback) {
		if ($('#usuarios #id').val()!=0){
			if (confirm ("Deseas eliminar el cliente "+ id +"," + nombre + "?")) {

				$.ajax({
					type: "GET",
					dataType: "json",
					data: {id:id},
					url: urlPhp+'usuarios/eliminar.php',
					beforeSend: function (){
						popup.close();
						$("#usuarios #rowUsuarios"+id).fadeTo("slow", 0.30);
					},
				})
				.done(function(){
					$("#usuarios #rowUsuarios"+id)
						.hide('explode')
						.remove();
				})
				.fail(function(){
					$("#usuarios #rowUsuarios"+id).show("fast");
					alert ("¡¡No se pudo borrar el registro!!");
				})
			}
		}else{
			popup.close();
		}
	},
	guardar: function (idUsuario,nombreUsuario,callback){
			var id= idUsuario||$('#usuarios #id').val();
			var data = $.isEmpty(nombreUsuario)
				?$("#frmUsuarios").serialize()
				:{nombre:nombreUsuario};

			$.ajax({
				type: "POST",
				dataType: "json",
				data: data,
				url: urlPhp+'usuarios/guardar.php',
			})
			.done(function(mns){
				var $this  =$('#frmUsuarios')
				var frm = $.serializeForm('frmUsuarios');
				letra = frm.nombre[0];
				var chckEmail =frm.email==""?'No':'Si';
				var chckObs = frm.obs==""?'No':'Si';
				var admin = (frm.admin)?1:0;
				var activa = (frm.activa)?1:0;
					if (id==0){ 
						//NUEVO ...
						$('#usuarios')
						find('.capaUsuarios')
							.prepend('\
								<tr id="rowUsuarios'+mns.id+'" data-value ="'+mns.id+'">\
									<td class="w2">\
										<span name="historia" class= "icon-doc-text x6 a" title="Historial de usuario"></span>\
										<span name="editar[]" class= "icon-edit x6 a"  title="Editar usuario"></span>\
									</td>\
									<td name= "id" class="num responsive">'+mns.id+'</td>\
									<td name="nom" class="nom" id="'+normalize(frm.nombre)+'">'+frm.nombre+'</td>\
									<td name="tel" class="responsive">'+frm.tel+'</td>\
									<td name="email" class="w1" data-value ="'+frm.email+'">'+chckEmail+'</td>\
									<td name="obs" class="obs responsive" data-value ="'+frm.obs+'">'+ chckObs +'</td>\
									<td name="admin" class="hidden" data-value ='+admin+'></td>\
									<td name="activa" class="hidden" data-value ='+activa+'></td>\
								</tr>\
							').end()
						find('#lstClientes')
							.append('<option data-id="'+normalize(frm.nombre)+'">'+frm.nombre+'</option>')
						
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
								.append('<option data-id="'+normalize(frm.nombre)+'">'+frm.nombre+'</option>')
						}			
					}
				typeof callback == "function" && callback();
			})
			.fail(function(r){echo ('ERROR guardar registro' + r);})
			.always(function(rsp){
				usuario.select(letra);
				resetBtnLoad();
				popup.close();
			});
	
	},
	poppup: function (id){
		dialog.create('dlgUsuarios',function(){
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
			dialog.open('#dlgUsuarios',usuario.guardar,function(){
				usuario.eliminar($('#dlgUsuarios #id').val(),$('#dlgUsuarios #nombre').val())
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
			.find('tr').hide().end()
			.find('.nom[id^='+letra.toLowerCase()+']').parent().show()
	},
	buscar: function (txt){
		var txt =  normalize(txt);
		usuario.select(txt.toUpperCase());
		var txt = txt.replace(/\s/g, "");
		txt = txt.toLowerCase();
		$("#usuarios").find(".body").fadeOut().end()
	},
}

$(function(){
	$('body').on('click',"[name='desplazarFecha']",function(e){
		if(!$(this).data('disabled'))sincronizar(null,$(this).data('action'));
	})
	$('.tabcontrol').tabcontrol();
	main.lbl.color();
	var agendas_width = $('#main .cabecera').data('agendas');
	var widht = $('#main').css('widht')/agendas_width	;
	var editarObs = "";
	$('html')
		.on('click','.close',function(e){popup.close()})
		.on('change','input',function(){$(this).removeClass('input-error')})
		.on('click','.dialog-close-button',function(){
			dialog.open($(this).parents('.dialog:first'));
		})
		.on('change','#lstSerSelect',function(){
				var id = $(this).val();
				// servicio.mostrar(id);
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
				btnLoad.hide();
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
		.on('click','a',function(){servicio.mostrar($(this).attr('id'))})
		.on('change','.lstServicios ',function(){servicio.mostrar($(this).val())})
		.on('click','[name="hora[]"]',function(){crearCita.dialog()})
		.on('click','.siguiente',function(e){crearCita.stepper($('div [id^="stepper"]:visible').data('value') + 1);})
		.on('blur','#cliente',crearCita.validate.name)
		.on("swipeleft",'.tablas');

	$('#familias')
		.on('click','table .icon-edit',function(){
			familias.mostrarPoppup($(this).attr('value'));
		})

	$('#general')
		.on('click','#btnCambiarPass',function(){
			dialog.create('dlgCambiarPass',function(){
				dialog.open('#dlgCambiarPass',function(e){
					config.cambiarContraseña();
				})
			})
		})
		.find('#generalFrm')
			.submit(function(e){
				e.preventDefault();
				general.guardar($(this)); //AKI ESTO DA ERROR (NO ES UNA FUNCION)
			});

	$('#main')
		.on('click','#mainLstDiasSemana a',function(){
			var diaA =  parseInt(Fecha.diaSemana(Fecha.general));
			var diaB = parseInt($(this).data('value'));
			sincronizar(null,diaB-diaA);
		})
		.on('change','#lstDiasSemana',function(){
			var diaA =  parseInt(Fecha.diaSemana(Fecha.general));
			var diaB = parseInt($(this).val());
			sincronizar(null,diaB-diaA);
		})
		.on('click','.icon-attention',function(e){main.citasSup($(this));e.stopPropagation()})
		.on('click','.icon-plus',function(){
				hora =$(this).parents('tr').attr('class').substr(1,2);
				var a = $(this).parent().data('agenda');
				mostrarCapa('crearCita',function(){
					$('#crearCita').find('#agenda'+a).prop('checked',true);
				});
		})
		.on('click','.cita',function(e){
			$(this).parent()
				.find('.note')
					.addClass('show')
					.find('input')
						.focus();

		})
		.on('focus','.celda .note input',function(){
			editarObs = $(this).val();
			$('.cuerpo')
				.off("swipeleft")
				.off("swiperight");
		})
		.on('blur','.celda .note input',function(e){
			$('.cuerpo')
				.on("swipeleft",function(){sincronizar(null,1)})
				.on("swiperight",function(){sincronizar(null,-1)});

			if($(this).val()=="")$(this).parent().parent().removeClass('show');
			if(editarObs != $(this).val()){main.guardarNota($(this).parent());}
		})
		.on('click','.celda .icon-cancel',function(e){
			e.stopPropagation();
			main.eliminar($(this))
		})
		.on('change','#selectTablasEncabezado',function(){main.responsive($(this))})
		.find('.tile').css('width',widht+'%').end()
		.find('.cuerpo')
			.on("swipeleft",function(){sincronizar(null,1)})
			.on("swiperight",function(){sincronizar(null,-1)})

	$('#navbar')
		.find('#btnShow').click(menu.show).end()
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
			if($('#usuarios').is(':visible')) usuario.select('A');
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
		.on('click','#btnOptions #chckOpUsersDel',function(){
			if ($(this).is(':checked'))
				$('.ocultar_baja').removeClass('ocultar_baja').addClass('mostrar_baja')
			else
				$('.mostrar_baja').removeClass('mostrar_baja').addClass('ocultar_baja')
		})
		.find('[name="menu[]"]').click(function(){
			mostrarCapa($(this).data('capa'));
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
		.on('click','a',function(){servicio.mostrar($(this).attr('id'),$('#servicios'))})
		.on('change','.lstServicios ',function(){servicio.mostrar($(this).val())})
		.on('change','#familia',function(){familias.change = true})
		.on( "click", "[name*='editar']", function(e){servicio.poppup($(this).attr('value'))})
		.find('option:first-child').attr('selected','selected');
		
	$('#dialogs')
		.on('click','#ppServicios #btnEliminar',function(){servicio.eliminar()})
		.on('click','#ppServicios #btnAceptar',function(){servicio.guardar()})
		.on('click',"#ppFamilias #btnEliminar",function(e){familias.eliminar(e)})
		.on('click','#ppFamilias #frmEditarFamilia',function(e){familias.guardar()})

		$('#familias input[name*="mostrar"]').change(function(){
			var mostrar = ($(this).is(':checked'))?1:0;
			var id = $(this).attr('id');
			familias.chckGuardar(id, mostrar);
		});

	$("#usuarios")
		.on('click','[name*="editar"]',function(){
			var id = $(this).parents('tr:first').data('value')
			usuario.poppup(id)
		})
		.on('click',"[name^='historia']",function(e){usuario.historial($(this))})
		.on('click','#mainLstABC a',function(){
			usuario.select($(this).html());
		})
		.on('change','#lstABC',function(){usuario.select($(this).val())})
		.on('click','.icon-search',function(){
			$('#popupHistorial').hide()
			$('.popup-overlay').hide()
			mostrarCapa('main')
			sincronizar($(this).parent().parent().data('fecha'))
		})

		//funciones
		cargarDatepicker();
		colorearMenuDiasSemana();
		main.inactivas($('#main .cuerpo').data('estado-inactivas')==1);
})
