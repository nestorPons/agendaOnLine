var urlPhp = "../../php/users/";
var admin = false;

var HORARIOS = document.horarios;
var FESTIVOS = document.festivos;
var AGENDA = document.agenda;
var crearCita = {
	crearHoras: function(fecha,callback){	
		$('#tablas table:visible').removeClass('activa');
		var fecha = fecha||Fecha.general;	
		var agenda =	 $('#crearCita input[name="agenda[]"]:checked').val()||1;
		var horas = new Array;
		var ruta = urlPhp +'cogerCita/horasCns.php';
		var arg = {f:fecha,a:agenda,e:nombreEmpresa};
		
		$('#login #crearCita #tablas table').fadeOut();

		$.get(ruta,arg,function(r){
			$.each(r,function(index, valor){	
				Fecha.id = index;
				if (!$('#'+Fecha.id).length){
					var clone = $('#principal').clone()
						clone
							.attr('id',Fecha.id)
							.appendTo('#tablas')
							.addClass('editando')
					$.each(valor,function(i, v){
						$this = $('#'+Fecha.id+' #h'+i);						
						$this.addClass('activa');
						if (v == 2) 
							$this
								.addClass('ocupado')
								.find('input').attr('disabled',true);
						
					})
					
					_ordenar(function(){
						$('.editando').removeClass('editando');
					});
				}
			})
			Fecha.id = Fecha.number($('.datepicker').val())
			crearCita.pintarHoras();
			$('#crearCita #'+Fecha.id).addClass('activa');
		},'json')

		$('#crearCita [data-role="preloader"]').fadeOut('slow');
		
		function _ordenar(callback){			
			var tr = $('.editando .activa').parent();
			var filas = tr.length
			var filasM = Math.round((filas/2));
			var n= 0;
			for (let f=filasM;f<=filas;f++){
				tr	
					.eq(f)
						.detach()
						.find('td')
							.addClass('secondColumn')
							.appendTo(tr.eq(n));
				n++;
			}
			typeof callback == "function" && callback();
		}
	},
	guardarCita: function (){
		$this = $('#cogerCitaFrm');
		var url = urlPhp+"cogerCita/guardar.php";
		var $hora = $('#cogerCitaFrm input:radio[name="hora[]"]:checked');
		var data = $this.serialize()+
			'&fecha='+Fecha.sql($('.datepicker').val())+
			'&usuario='+$('body').data('iduser');
		$.getJSON(url,data,function(r,status){
			if(r.success){
				$.Notify({
					caption: 'Guardado',
					content: 'Su cita ha sido guardada',
					type: 'success',
					icon: 'icon-floppy'
				})

				_insertarHistorial(r.data);
				_ocuparHoras(r.hora);
				
				$('#crearCita').removeAttr('style');
				cerrarMenu('#crearCita');	
			}else{
				$.Notify({
					timeout: 4000,
					type: 'alert',
					caption: 'Error, HORA OCUPADA',
					content: 'No se ha podido guardar la cita\n seleccione otra hora.',
					icon: 'icon-cross'
				})
				$('.dialog').hide();
				btnLoad.reset();
			}
		}).fail(function(r){console.log("ERROR=>"+r.success);})
		
		function _ocuparHoras(horas){
			$.each(horas,function(i,v){
				$('#'+Fecha.id+' #h'+v).addClass('ocupado')
			})
		}
		
		function _insertarHistorial(data){

			var arrHistorial = new Array()
			var hora = $('#tablas :radio:checked').val()
			var fecha = Fecha.sql($('.datepicker').val());
		
			$('#stepper1 input:checkbox:checked').each(function(i){
				var tiempoServicio = $(this).data('time');
				var numLineas= parseInt(Math.ceil(tiempoServicio/15))||0;
				var servicio = $(this).data('descripcion');
				var codigo = $(this).data('codigo');
				
				for(let i =0 ; i <= numLineas; i++){
					var $clone = $('#historial #tableHistory tr:last');
					$clone
						.find('tr')
							.attr('id','tr'+data.idCita[i])
							.attr('class',data.id+codigo)
							.attr('idcita',data.id)
							.data('fecha',fecha)
							.data('hora',hora+i)
						.end()
						.find("td:eq(0)")
							.attr('id',data.idCita[i])
						.end()
						.find("td:eq(1)")
							.html($('.datepicker').val() + ' a las '+ ARRAYHORAS[parseInt(hora)+i] )
						.end()
						.find("td:eq(2)")
							.html(servicio)
						.end()
						.appendTo('#tableHistory')
				}
				
			})
		}
	},
	msgBoxGuardar: function (){
		if (!$('#dialogs #dlgGuardarCita').length){
			var url  = '../../php/users/cogerCita/lib/dlgGuardar.html';
			var hora = ARRAYHORAS[$('#crearCita [name="hora[]"]:checked').attr('id')];
			$.get(url,function(html){
				$('#dialogs')
					.append(html)
					.find('#lblHora')
						.html(hora).end()
					.find('#lblFecha')
						.html(Fecha.print(Fecha.general)+', ');
				dialog.open('#dlgGuardarCita',crearCita.guardarCita)
			})			
		}else{
			dialog.open('#dlgGuardarCita',crearCita.guardarCita)
		}
		
	},
	stepper: function (index){
			var $visible = $('.steperCapa:visible');
			var $stepper = $('#stepper'+index);
			if($visible.attr('id')==$stepper.attr('id'))return false;
			if (!$stepper.is(':visible')&&$visible.length){
				if(index==0){_slider();}
				else if(index==1){_slider();}
				else if(index==2&&validarServicios()){_slider(sincronizar)};
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
	pintarHoras: function (callback){
			var tiempoServicios = _tiempoServicios();
			var ts = parseInt(Math.ceil(tiempoServicios/15))||0;
			var totalTablas = $('#tablas table').length
			$('.hora.activa.reservado')
				.removeClass('reservado')
				.find('input').attr('disabled',false)
			
			for (let d = 0; d < totalTablas; d++){
				var $this =  $('#tablas table').eq(d);
				var last = $this.find('td.activa:last input').attr('id');
				var first = $this.find('td.activa:first input').attr('id');
				var fecha = $this.attr('id');
				var diaFestivo = $.inArray(Fecha.md(fecha),FESTIVOS)!=-1;

				for(let i =  last; i >=first ; i--){
					if(diaFestivo||_esPasada(i)){ 
						_colorear(i);
					}else{
						if(_ocupado(i)||i==last){
							for(let l = 0; l < ts; l++){
								_colorear(i-l);
							}
						}					
					}
				}
			}
			typeof callback == "function" && callback();
			
			function _ocupado(hora){
				var celda =  $this.find('#h'+hora+'.ocupado');
				return celda.length != 0 ; 
			}
			
			function _tiempoServicios(hora){
				var ts = 0;
				$('#crearCita [name="servicios[]"]:checked').each(function() {
					ts += $(this).data('time');
				})
				$('#tSer').html(ts);
				return ts;
			}
			
			function _colorear(hora){				
				$this.find('#h'+hora)
					.addClass('reservado')
					.find('input').attr('disabled',true)
			}
			
			function _esPasada(hora){
				var minTime = $('body').data('mintime')*60000;
				var milisegundos = new Date().getTime();
				
				var fecha = new Date(milisegundos +minTime);
				var id = $this.attr('id')
			
				var h = ARRAYHORAS[hora];
				var day = parseInt(id.substr(6,2));
				var hour = parseInt(h.substr(0,2));
				var min = parseInt(h.substr(3,5));
				var month = parseInt(id.substr(4,2));
				var year = parseInt(id.substr(0,4));

				var hora = new Date(year,month-1,day,hour,min);

				var fechaEsMayor = Date.parse(hora)<Date.parse(fecha);

				return  (fechaEsMayor);
					
			}
		},
}
var historial = {
	eliminar: function($this){			
		var id = $this.attr('id')
		var $this = $this.parent();
		var fecha =  Fecha.number($this.data('fecha'));
		var hora = $this.data('hora');
		var idSer = $this.attr('class');
		var $rows = $("#historial #tableHistory ."+idSer);
		$.ajax({
			type: "GET",
			dataType: "json",
			data: {
				idCita: $this.attr('idcita'),
				idSer: $this.attr('idser'),
				user:$('body').data('iduser')
			},
			url: urlPhp +'historial/eliminar.php',
			beforeSend: function (){
				$rows.fadeTo("slow", 0.30);
				$rows
					.find('.icon-cancel').hide().end()
					.find('.icon-load').css('display','inline-block')
			},
		})	
		.done(function(r){	
			$rows.fadeOut('slow');
			$('#crearCita #tf'+fecha+' #'+hora+' label').removeClass('ocupado')
				.find('input').attr("disabled", false)
			$('#lblHis').html(r.nr)
		})

	},
	numeracion:function(){
		var num = $('#historial #tableHistory tr').length
		$('#lblHis').html(num)
	},
}
var usuario = {
	guardar: function(e,$this){alert();
			e.preventDefault();
			var pass1 = $('#pass').val()		
			var pass2 = $('#rpass').val()
			if (pass1!=""&&pass2!=""){
				pass1 = SHA1(pass1);
				pass2 = SHA1(pass2);
			}
			var data = {
				"idUsuario":$('#idUsuario').val() ,
				"e":nombreEmpresa,
				"nombre":$('#nombre').val() ,
				"email":$('#email').val(),
				"tel":$('#tel').val(),
				"oldPass":oldPass,
				"pass1":pass1,
				"pass2":pass2
		        };
				
			$.ajax({
				type: "POST",
				data: data,
				url: urlPhp +"usuario/guardar.php",
				dataType: 'json',
			})
			.done(function(rsp,status){
				if(rsp.success){
					$('#lblUser').html($('#nombre').val());
					cerrarMenu();
					$('#lblUser').val($('#config #usuarioFrm #nombre').val()) 
					$.Notify({
						caption: 'Guardado',
						content: 'Sus datos han sido guardados',
						type: 'success',
						icon: 'icon-floppy'
					})				
				}else{
					$.Notify({
						caption: 'Error',
						content: 'No se han podido guardar los datos',
						type: 'alert',
						icon: 'icon-cross'
					})
				}
			})	
			.fail(function(r){console.log("ERROR=>"+r.success);})
			.always(hideLoad)
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
	$("[name='desplazarFecha']").click(function(e){
		var dir = $(this).data('action');
		sincronizar(null,dir)
	})	
	$('input:password').blur(function(){
		var pass1 = $('#pass').val()		
		var pass2 = $('#rpass').val()
		validarPass(pass1,pass2)
	})
	$('#lblUser').html($('#nombre').val());
	$('.tile-content').click(function(e){menuAbrir($(this).parent())});
	$('.nextSteeper').click(function(){
		var val = $('.steperCapa:visible').data('value')
		crearCita.stepper(val+1)
	})
	$('#crearCita')
		.on('click','[name="hora[]"]',crearCita.msgBoxGuardar)
		.find('#tablas')
			.on("swipeleft",function(){sincronizar(null,1)})
			.on("swiperight",function(){sincronizar(null,-1)})
		.end()
		.find('#mnuFamilias')
			.on('click','a',function(){mostrarCapaServicios($(this).attr('id'))})
			.on('change','#seleccion',function(){mostrarCapaServicios($(this).val())})
		.end()
		.find('#btnCancelarDlg')
			.click(function(){closeDialog('#crearCita #dlgCliente')})	
		
	$('#historial #tableHistory')
		.on('click','.icon-cancel',function(){
			historial.eliminar($(this).parent())
		})
	$('#calNotas').click(function(e){cargarCalendario();})
	$('#usuarioFrm')
		.submit(function(e){usuario.guardar(e,$(this))})
		.on('blur','#oldPassFake',function(){
			$('#oldPass').val(SHA1($(this).val()))
			usuario.comprobarContraseña($('#oldPass'));
		})
		.on('change','#oldPassFake',function(){
			$(this).removeClass('input-error input-success');
		})
		.on('blur','#passFake',function(){
			$('#pass').val(SHA1($(this).val()))
		})
		.on('blur','#rpassFake',function(){
			$('#rpass').val(SHA1($(this).val()))
		})
	$('#eliminar').click(function(){eliminarUsuario();})
	$(".cerrar").click(function(e){
		cerrarMenu();
		e.stopPropagation();		
	})
	fnReloj();
	historial.numeracion();
});
function sincronizar(fecha,dias,callback){
	var fecha = fecha||Fecha.general;
	if (dias)
		fecha =  Fecha.calcular(dias, fecha);
	else
		dias = 0;

	if(Fecha.restar(fecha)<0) return false;
	
	Fecha.general = Fecha.sql(fecha);	
	Fecha.id = Fecha.number(Fecha.general);
	
	$('.datepicker')
			.val(Fecha.print(fecha))
			.datepicker("setDate",Fecha.print(fecha));
			
	if(!$('#crearCita #tablas #'+Fecha.id).length){
		echo ('creando_las_horas_sincronizar')
		crearCita.crearHoras();
	}else{
		var content = $('#tablas') ;
		slideDias(content,dias,callback)		
	}	
}
function mostrarCapaServicios(a) {
	var a = a||1;
	$(".contenedorTablas").slideUp().delay(400);
	$("#capa"+a).slideDown();
};
function validarFormulario(tipoObj,callback){
	return $('#crearCita [name="servicios[]"]:checked').length!==0&&$('#crearCita #cliente').val()!==""&&$('#crearCita [name="hora[]"]:checked').length!==0;
};

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
		crearCita.pintarHoras();
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
	var $this = $('.tile-active');	
	btnLoad.reset();
	crearCita.stepper(0);
	
	if(typeof(ancho) != "undefined"){
		$last.animate({
			height: alto,
			width: ancho
		},750)
		$last.removeAttr('style')
	}
	$last = $this;
	ancho = $this.width();
	alto = $this.height();
	
	$('.mensaje').show();
	$('.contenido').hide();
	$("input:checkbox").attr('checked', false);
	$('.dialog').hide();
	$('.popup-overlay').hide();
	$('#crearCita input[name="hora[]"]:checked').prop('checked',false);
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
!function pilaDeFunciones(){
		cargarDatepicker();
}()
