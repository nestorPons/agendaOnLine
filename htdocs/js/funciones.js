"use strict"

var ADD = 'add', SAVE = 'save', DEL = 'del', EDIT = 'edit', VIEW = 'view', INDEX = 'index' , 
LEFT = 'left' , RIGHT = 'right', JSON = 'json', GET = 'get' 

var HORARIOS = document.horarios
var FESTIVOS = document.festivos

var ruta = window.location.pathname;
var arraynombre = new Array
arraynombre = ruta.split("/")
var nombreEmpresa = $('body').data('empresa')

var horarios = new Array()
var festivos = new Array()

//Contains para que sea insensible a mayusculas y minusculas
jQuery.expr[":"].contains = jQuery.expr.createPseudo(function(arg) {
 return function( elem ) {
  return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
 }
})
$.fn.removeClassPrefix = function(prefix) {
    this.each(function(i, el) {
        var classes = el.className.split(" ").filter(function(c) {
            return c.lastIndexOf(prefix, 0) !== 0;
        });
        el.className = $.trim(classes.join(" "));
    });
    return this;
};
jQuery.isEmpty = function(){
	var isEmpty = false 
	for (var i = 0; i < arguments.length; i++) {
		let arg = arguments[i] ;
		isEmpty =
		typeof arg == 'undefined' || arg === null || arg === false|| arg <1 ||arg === ''?true:
		typeof arg == 'number' && isNaN(arg)?true:
		arg instanceof Date && isNaN(Number(arg))?true:
		arg.length==0;

		if (isEmpty) break
	}
	return isEmpty;

 }
jQuery.serializeForm = function(form){
	var $form = $('#'+form);
	var inputs = $form.find('input:not(:button)');
	var arr_return = new Array();
	
	$.each(inputs,function(){
		var index = $(this).attr('id');
		var value =  $(this).is(':checkbox') ?$(this).is(':checked'):$(this).val();
		arr_return[index] = value;
	})

	return arr_return;
}
var $_GET = {};
function decode(s) {
	return decodeURIComponent(s.split("+").join(" "));
 }
document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
$_GET[decode(arguments[1])] = decode(arguments[2]);
});
var Fecha = {
	actual: fechaActual(),
	general: formatofecha(fechaActual(),'sql'),
	anterior: '1990-01-01', 
	id:  formatofecha(fechaActual(),'number'), //inicializo con fecha actual pero es un id.
	day : formatofecha(fechaActual(),'day'),
	month : formatofecha(fechaActual(),'month'),
	year : formatofecha(fechaActual(),'year'),
	sql: function(fecha){return formatofecha(fecha,'sql')},
	print: function(fecha){return formatofecha(fecha,'print')},
	md: function(fecha){return formatofecha(fecha,'md')},
	number: function(fecha){return formatofecha(fecha,'number')},
	day : function(fecha){return formatofecha(fecha,'day')},
	month : function(fecha){return formatofecha(fecha,'month')},
	year : function(fecha){return formatofecha(fecha,'year')},
	calcular: function(days,fecha){
		var fecha = fecha||Fecha.general
		fecha= "undefined"==fecha?Fecha.general:fecha
		fecha = Fecha.array(fecha)

		var milisegundos=parseInt(35*24*60*60*1000)

		var day=fecha.getDate()
		// el mes es devuelto entre 0 y 11
		var month=fecha.getMonth()+1
		var year=fecha.getFullYear()
		//Obtenemos los milisegundo desde media noche del 1/1/1970
		var tiempo=fecha.getTime()
		//Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
		milisegundos=parseInt(days*24*60*60*1000)
		//Modificamos la fecha actual
		var total=fecha.setTime(tiempo+milisegundos)
		day=fecha.getDate()
		month=fecha.getMonth()+1
		year=fecha.getFullYear()

		return  year+"-"+month+"-"+day

	 },
	diaSemana: function(fecha){
	    var fecha = Fecha.array(fecha);
		return fecha.getDay();
	 },
	restar: function (f1,f2){
		var f2  = $.isEmpty(f2)?this.actual:this.sql(f2);
		var f1 = this.sql(f1);
	
		var afecha1 = f1.split('-');
		var afecha2 = f2.split('-');
		var ffecha1 = Date.UTC(afecha1[0],afecha1[1]-1,afecha1[2]);
		var ffecha2 = Date.UTC(afecha2[0],afecha2[1]-1,afecha2[2]);
		var dif = ffecha1 - ffecha2 	;

		return Math.floor(dif / (1000 * 60 * 60 * 24));
	 },
	array : function ( fecha ) {
		var fecha = fecha||Fecha.general
		var fecha = Fecha.sql(fecha)
		var mdy = fecha.split('-')
		return new Date(mdy[0], mdy[1]-1, mdy[2])
	 }
 }
var generateId = {
	encode : function (a , f , h) {
		a = ("0" + a).slice(-2)
		f = formatofecha(f,'number')
		h = h.split(':')

		return a + f + h[0] + h[1]
	 },
	decode : function (value) {

		var result = new Object()
		result.agenda = value.substr( 0, 2 )

		var date =  value.substr( 2, 8)
		result.date = Fecha.sql(date)

		var hora = value.substr( 10 )
		result.hour = hora.substr(0,2) + ':' + hora.substr(2,2)

		return result
	 }
 }
var btn = {
	active : null , 
	caption : null,
	load : {
		status: true, //variable para impedir que aparezca el load en los botones si esta en falso.
		show : function($this, status){
			var $btn = $this.find('.icon-load')
			if (btn.load.status && !$btn.length){
				btn.caption = $this.html()
				$this.prepend('<span class="icon-load animate-spin"></span>');
				btn.active = $this ;
			} else {
				$btn.show()
			}
			
			btn.load.status = true;	

			},
		hide : function(){
				var $this = btn.active||$('.icon-load:visible').parent();
				var caption = $this.data('value');
				setTimeout(function() {
					$('.animate-spin').hide()
				 }, 1000);
			},
		reset :	function (callback){
			$('.btnLoad').each(function(){
				$(this).html($(this).data('value'))
			});
			btn.active = null ;
			typeof callback == "function" && callback();
			}
		},
	save : {
		show : function (){
			$('#btnSave')
				.find('.icon-floppy').show().end()
				.find('.icon-load').hide()
		}
		},
 }
var validar = {
	nombre: {
		funcion:function($this){
			if(!$.isEmpty($this.val())){
				if($this.val().length>6){
					$this
						.addClass("input-success")
					
					validar.nombre.estado = true;
				}else{
					var $popover = $('#'+$this.attr('id')+'PopoverTxt')
					if ($popover.lengh){
						$('#'+$this.attr('id')+'PopoverTxt')
								.html('El nombre tiene que tener más de 6 caracteres.')
						$this
							.addClass("input-error")
							.popover('show');
					}else{
						$.Notify({
							id: 'lbl'+$(this).attr('id'),
							type: 'alert',
							caption: 'nombre de usuario',
							content: 'El nombre tiene que tener un mínimo de 7 caracteres. ',
							icon: "icon-user-times"
						})
					}
					validar.nombre.estado = false;
				}
			}else{
				$this.val('');
				validar.nombre.estado =  false;
			}
		},
		estado: false
	},
	email:{
		funcion:function($this){
			if(validar.email.estado) return false;
			var email = $this.val();
			var $lblPopover = $('#'+$this.attr('id')+'PopoverTxt');
			if(!$.isEmpty(email)){			
				if(email.indexOf('@') == -1 || email.indexOf('.')==-1){
					
					if(!$this.hasClass('input-error')){
						$.Notify({
							id: 'lblEmail',
							type: 'alert',
							caption: 'Email',
							content: 'Escriba un email válido. ',
							icon:'icon-mail-1'
						})
				
						if(validar.email.colorear){
							$this
								.addClass('input-error')
								.removeClass('input-success')						
						}
						validar.email.estado = false;
					}
				}else{
					if(typeof validar.email.callback == "function"){
						validar.email.callback();
					}else{
						if(validar.email.colorear)
							$this.addClass('input-success').removeClass('input-error')
					}
						
					validar.email.estado = true;
				}
			}else{
				$this.val('');
				validar.email.estado = false;
			}
		},
		estado: false,
		callback: false,
		colorear: true,
	},
	tel:{
		funcion:function ($this){ 
			var tel = $this.val();
			if(!$.isEmpty(tel)){
				if(tel.length>=8){
					$this.addClass('input-success')
					validar.tel.estado =  true;
					var r = true
				}else{
					$this.addClass('input-error')
					validar.tel.estado =  false;
					var r = false
				}
			}
			return r
		},
		estado: true,
	},
	pass: {

		estado: false,
		funcion:function($this){
			var pass = SHA($this.val())

		   	$this.siblings('#pass').val(pass)
	
			if (!$.isEmpty($this.val())){				
				if($this.val().length>6){
					
					$this.addClass('input-success');

					var $pass = $(':password');
					
					//esto solo es para cuando se quiere cambiar la contraseña desde config 
					var n = ($this.parents('#dlgCambiarPass').length>0)?1:0;

					if ($pass.length>1){
						if ($this.attr('id') === $pass.eq(n+1).attr('id'))
						if ($pass.eq(n+1).val()!=$pass.eq(n).val()&&$pass.eq(n+1).val()!=""){
							$this.addClass('input-error').removeClass('input-success');
							validar.pass.estado =  false;
						}else{
							$this.addClass('input-success').removeClass('input-error');
							validar.pass.estado =  true;
						}
					}
				}else{
					if(!$this.hasClass('input-error') && !$('.email').hasClass('input-error')){
						$this.removeClass('input-success').addClass('input-error');
						$.Notify({
							id:'lblPass',
							type: 'warning',
							caption: 'Contraseña',
							content: 'Tiene que tener más de 6 carácteres.',
							icon:'icon-lock'
						})
					}
					validar.pass.estado =  false;
				}
			} else {
				$this.removeClass('input-error input-success')
				return false;
			}
		},
		reset: function($this){
			$this.find(':password').each(function(){
				$(this).removeClass('input-error input-success').val('') ;
			})
		}
	},	
	form : function(idFrm){
	//AKI :: personalizando mensaje de error 
	//AKI :: cambiar forma de validar el formulario
		var frm = $('#'+idFrm);

		if (frm[0].checkValidity() != false){
			return true; 
		}else{
			notify.error(frm[0].validationMessage,'Error formulario')
			return false ;
		}		

	},
 }
var input = {
	success : function ($input) {
		if($.isEmpty()) return false
		$input.removeClass('input-error').addClass('input-success')
	}, 
	error : function ($input) {
		if($.isEmpty()) return false
		$input.removeClass('input-success').addClass('input-error')
	}
 }
var dialog = {
	loads: new Array,
	section : $('#dialogs') , 
	isOpen : null, 
	open:function(objName,fnOk,fnCancel,callback){
		dialog.isOpen = objName

		var $this = dialog.section.find('#'+objName), 
			loads = dialog.loads,
			_open = function($this){
				$this.show('fade','fast',function(){
					$(this).find('.iconClass-container input').first().focus()
				})
					

				$('.popup-overlay').fadeIn()
			
			}

		if(loads.indexOf(objName)==-1){
			
			loads.push(objName)	
			dialog.create(objName,fnOk,fnCancel,function(){

				_open( $('#dialogs #'+objName))
				typeof callback == "function" && callback(true)	

			})

		}else{
	
			dialog.reset(objName)
			_open($this)
			typeof callback == "function" && callback(false)	
			
		}
	 },
	close:function (objName,callback){

		var $this = $('#'+objName) || $('.dialog').is(':visible');

		//en el caso que existan passwords formaear el diseño
		validar.pass.reset($('#'+objName) )

		$this.fadeOut()
		$('#dialogs').fadeOut()
		dialog.isOpen = null
		typeof callback == "function" && callback();
	 },
	create: function (objName,fnOk,fnCancel,callback){
			
			var data = {
				controller : 'dialogs' , 
				view : objName 
			}

			 $.post(INDEX,data,function(html){

				$('#dialogs')
					.append(html)
					.promise()
					.done(function(){
					
					var $this = $('#dialogs').find('#'+objName)

						$this.draggable({		
							disabled : false, 
							opacity : 0.70 , 
							zIndex: 100 ,
							start : function(){}
						})
							.keypress(function(e){
									var code = e.keyCode ;
					
									//BOTON PREDETERMINADO EN LOS DIALOGS
									if(event.which==13) 
										$this.find('.aceptar').click()

							})
							
					$this.on('click','.fnClose',function(){
						dialog.close(objName)
					})
					$this.on('click','.btn-danger',function(e){
						typeof fnCancel == "function"?fnCancel():dialog.close(objName)
					})
					$this.on('click','.btn-success',function(e){
						typeof fnOk == "function" && fnOk()
					})
			
	
					typeof callback == "function" && callback(true)
				})
				


			 },'html')


	 },
	reset : function(objName){
		var $this = $('#'+objName)
		var $load = $this.find('.btnLoad');
		btn.load.reset()
		if ($this.find('form').length){
			$this.find('form')[0].reset()
		} else {
			$this.find('input').each(function(){
				$(this).val('')					
			})
			$this.find('.lst').each(function(){
				$(this).empty()
			})
		}

		if($load.length){
			$load.each(function(){
				var caption = $(this).data('value');
				$(this).html(caption)
			})
		}

	 }
 }
var notify = {
	success: function(mns,cptn, keep, $input){
		var keepOpen = keep||false;
		var cptn = cptn||'Guardado';
		var mns = mns||'El registro ha sido guardado';
		$.Notify({
			type: 'success',
			caption: cptn,
			content: mns,
			icon: 'icon-floppy', 
			keepOpen: keep,
		})

		if (!$.isEmpty($input)) input.success($input)
	},
	error: function(mns,cptn,keep, $input){
		var keepOpen = keep||false;
		var cptn = cptn||'Error';
		var mns = mns||'Ha ocurrido un error';
		$.Notify({
			type: 'alert',
			caption: cptn,
			content: mns,
			icon: 'icon-cross',
			keepOpen: keep,
		})
		if (!$.isEmpty($input)) input.error($input)
	},
	alert: function(mns,cptn,keep){
		var keepOpen = keep||false;
		var cptn = cptn||'Warning';
		var mns = mns||'Alerta algo requiere su atencion';
		$.Notify({
			type: 'warning',
			caption: cptn,
			content: mns,
			icon: 'icon-attention',
			keepOpen: keep,
		})
	},
 }
function formatofecha (fechaTxt,formatOut){ 

	var fecha = !$.isEmpty(fechaTxt)?fechaTxt.toString():Fecha.general;

	if (fecha.indexOf("/")>0){
		var mdy = fecha.split('/');
		var d = ("0" + mdy[0]).slice (-2);
		var m = ("0" + mdy[1]).slice (-2);
		var a = mdy[2];
	}else if(fecha.indexOf("-")>0){
		var mdy = fecha.split('-');
		var d = ("0" + mdy[2]).slice (-2);
		var m = ("0" + mdy[1]).slice (-2);
		var a = mdy[0];
	}else if(fecha.length==4){
		var d = fecha.substr(2);
		var m = fecha.substr(0,2);
		var a =  fechaActual('y');
	}else if(fecha.length==8){
		var d = fecha.substr(6,2);
		var m = fecha.substr(4,2);
		var a =  fecha.substr(0,4);
	}
	switch(formatOut) {
		case 'sql':
			var fch= a+'-'+m+'-'+d;
			break;
		case 'print':
			var fch= d+'/'+m+'/'+a;
			break;
		case 'md':
			var fch = m+d;
			break;
		case 'number':
			var fch = a+m+d;
			break;
		case 'day':
			var fch = d;
			break;
		case 'month':
			var fch = m;
			break;
		case 'year':
			var fch = a;
			break;
		default:
		   var fch = new Date(a, m-1,d);
	}

	return (fch); 
 }
function fechaActual(arg){ 
	var arg = arg||null;
	var fecha_actual = new Date();
	var mes = fecha_actual.getMonth()+1;
	var r =  arg=="y"?fecha_actual.getFullYear()
				:arg=="m"?mes
				:arg=="d"?fecha_actual.getDate()
				:fecha_actual.getFullYear() +"-"+ mes +"-"+ fecha_actual.getDate();


	return  r;
 }
function cargarDatepicker(callback){
	var $dp = $('.datepicker');
	var format = $dp.data('format')||"dd/mm/yy";
	var fesOn = $dp.data('festivos-show');
	var minDate = $dp.data('min-date');

	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '',
		nextText: '',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: '',
	};
	$.datepicker.setDefaults($.datepicker.regional["es"]);
	$dp.datepicker({
		minDate: minDate,
		firstDay: 1,
		dateFormat: format,
 
		beforeShowDay: function (date){
			var current = $.datepicker.formatDate('mmdd', date);
			var day = date.getDay()
			return day == 0 ||$.inArray(current,  FESTIVOS) > -1?[fesOn, "festivo"]:[true, ""];
		},
		onSelect: function (fecha) {
			
			sincronizar(null, fecha)

		},
		onClose: function(){
			this.blur();
		},
		defaultDate: Fecha.print()|| new Date(),
		showAnim: 'blind',
	});
	$dp.each(function(){$(this).val(Fecha.print())})
	
	typeof callback == "function" && callback();
 }
function colorearMenuDiasSemana(arg){
	var fecha = arg||Fecha.general;
	$('.highlighted').removeClass('highlighted');
	var f = new Date();
	f = formatofecha(fecha);
	var d = f.getDay() !=0?f.getDay():7;
	$("#mainLstDiasSemana #mainMenu"+d).addClass("highlighted");

	$("#lstDiasSemana").val(d);

	//coloreo rojo festivos en datepicker
	var fes = formatofecha(fecha,'md');
	if(d==7||$.inArray(fes,festivos.year)!=-1)
		$('.datepicker').css('color','#e04747')
	else
		$('.datepicker').css('color','inherit')
	

 }
function hideShow(param){
	for (var i = 0; i < arguments.length; ++i) {
			let $obj = $(arguments[i])
			$obj.toggle();
	}
 }
function normalize(string){

	var str = string.trim().split(" ").join("");
	if ($.isEmpty(str))return false;
	var map={
		'À':'A','Á':'A','Â':'A','Ã':'A','Ä':'A','Å':'A','Æ':'AE','Ç':'C','È':'E','É':'E','Ê':'E','Ë':'E','Ì':'I','Í':'I','Î':'I','Ï':'I','Ð':'D','Ñ':'N','Ò':'O','Ó':'O','Ô':'O','Õ':'O','Ö':'O','Ø':'O','Ù':'U','Ú':'U','Û':'U','Ü':'U','Ý':'Y','ß':'s','à':'a','á':'a','â':'a','ã':'a','ä':'a','å':'a','æ':'ae','ç':'c','è':'e','é':'e','ê':'e','ë':'e','ì':'i','í':'i','î':'i','ï':'i','ñ':'n','ò':'o','ó':'o','ô':'o','õ':'o','ö':'o','ø':'o','ù':'u','ú':'u','û':'u','ü':'u','ý':'y','ÿ':'y','Ā':'A','ā':'a','Ă':'A','ă':'a','Ą':'A','ą':'a','Ć':'C','ć':'c','Ĉ':'C','ĉ':'c','Ċ':'C','ċ':'c','Č':'C','č':'c','Ď':'D','ď':'d','Đ':'D','đ':'d','Ē':'E','ē':'e','Ĕ':'E','ĕ':'e','Ė':'E','ė':'e','Ę':'E','ę':'e','Ě':'E','ě':'e','Ĝ':'G','ĝ':'g','Ğ':'G','ğ':'g','Ġ':'G','ġ':'g','Ģ':'G','ģ':'g','Ĥ':'H','ĥ':'h','Ħ':'H','ħ':'h','Ĩ':'I','ĩ':'i','Ī':'I','ī':'i','Ĭ':'I','ĭ':'i','Į':'I','į':'i','İ':'I','ı':'i','Ĳ':'IJ','ĳ':'ij','Ĵ':'J','ĵ':'j','Ķ':'K','ķ':'k','Ĺ':'L','ĺ':'l','Ļ':'L','ļ':'l','Ľ':'L','ľ':'l','Ŀ':'L','ŀ':'l','Ł':'L','ł':'l','Ń':'N','ń':'n','Ņ':'N','ņ':'n','Ň':'N','ň':'n','ŉ':'n','Ō':'O','ō':'o','Ŏ':'O','ŏ':'o','Ő':'O','ő':'o','Œ':'OE','œ':'oe','Ŕ':'R','ŕ':'r','Ŗ':'R','ŗ':'r','Ř':'R','ř':'r','Ś':'S','ś':'s','Ŝ':'S','ŝ':'s','Ş':'S','ş':'s','Š':'S','š':'s','Ţ':'T','ţ':'t','Ť':'T','ť':'t','Ŧ':'T','ŧ':'t','Ũ':'U','ũ':'u','Ū':'U','ū':'u','Ŭ':'U','ŭ':'u','Ů':'U','ů':'u','Ű':'U','ű':'u','Ų':'U','ų':'u','Ŵ':'W','ŵ':'w','Ŷ':'Y','ŷ':'y','Ÿ':'Y','Ź':'Z','ź':'z','Ż':'Z','ż':'z','Ž':'Z','ž':'z','ſ':'s','ƒ':'f','Ơ':'O','ơ':'o','Ư':'U','ư':'u','Ǎ':'A','ǎ':'a','Ǐ':'I','ǐ':'i','Ǒ':'O','ǒ':'o','Ǔ':'U','ǔ':'u','Ǖ':'U','ǖ':'u','Ǘ':'U','ǘ':'u','Ǚ':'U','ǚ':'u','Ǜ':'U','ǜ':'u','Ǻ':'A','ǻ':'a','Ǽ':'AE','ǽ':'ae','Ǿ':'O','ǿ':'o'
	};
	var res=''; //Está variable almacenará el valor de str, pero sin acentos y tildes
	for (var i=0;i<str.length;i++){
		let c=str.charAt(i);res+=map[c]||c;
	}
	res =
		res
		.replace(/\s/g, "")
		.toLowerCase()
		.trim();
	return res;

 } 
function echo(){
	for(let i = 0 ; i < arguments.length; i++){
		console.log(arguments[i]);
	}
 }
function SHA(str) {
 /*
	*  Secure Hash Algorithm (SHA512)
	*  http://www.happycode.info/
	*/ 	

  function int64(msint_32, lsint_32) {
    this.highOrder = msint_32;
    this.lowOrder = lsint_32;
  }

  var H = [new int64(0x6a09e667, 0xf3bcc908), new int64(0xbb67ae85, 0x84caa73b),
      new int64(0x3c6ef372, 0xfe94f82b), new int64(0xa54ff53a, 0x5f1d36f1),
      new int64(0x510e527f, 0xade682d1), new int64(0x9b05688c, 0x2b3e6c1f),
      new int64(0x1f83d9ab, 0xfb41bd6b), new int64(0x5be0cd19, 0x137e2179)];

  var K = [new int64(0x428a2f98, 0xd728ae22), new int64(0x71374491, 0x23ef65cd),
      new int64(0xb5c0fbcf, 0xec4d3b2f), new int64(0xe9b5dba5, 0x8189dbbc),
      new int64(0x3956c25b, 0xf348b538), new int64(0x59f111f1, 0xb605d019),
      new int64(0x923f82a4, 0xaf194f9b), new int64(0xab1c5ed5, 0xda6d8118),
      new int64(0xd807aa98, 0xa3030242), new int64(0x12835b01, 0x45706fbe),
      new int64(0x243185be, 0x4ee4b28c), new int64(0x550c7dc3, 0xd5ffb4e2),
      new int64(0x72be5d74, 0xf27b896f), new int64(0x80deb1fe, 0x3b1696b1),
      new int64(0x9bdc06a7, 0x25c71235), new int64(0xc19bf174, 0xcf692694),
      new int64(0xe49b69c1, 0x9ef14ad2), new int64(0xefbe4786, 0x384f25e3),
      new int64(0x0fc19dc6, 0x8b8cd5b5), new int64(0x240ca1cc, 0x77ac9c65),
      new int64(0x2de92c6f, 0x592b0275), new int64(0x4a7484aa, 0x6ea6e483),
      new int64(0x5cb0a9dc, 0xbd41fbd4), new int64(0x76f988da, 0x831153b5),
      new int64(0x983e5152, 0xee66dfab), new int64(0xa831c66d, 0x2db43210),
      new int64(0xb00327c8, 0x98fb213f), new int64(0xbf597fc7, 0xbeef0ee4),
      new int64(0xc6e00bf3, 0x3da88fc2), new int64(0xd5a79147, 0x930aa725),
      new int64(0x06ca6351, 0xe003826f), new int64(0x14292967, 0x0a0e6e70),
      new int64(0x27b70a85, 0x46d22ffc), new int64(0x2e1b2138, 0x5c26c926),
      new int64(0x4d2c6dfc, 0x5ac42aed), new int64(0x53380d13, 0x9d95b3df),
      new int64(0x650a7354, 0x8baf63de), new int64(0x766a0abb, 0x3c77b2a8),
      new int64(0x81c2c92e, 0x47edaee6), new int64(0x92722c85, 0x1482353b),
      new int64(0xa2bfe8a1, 0x4cf10364), new int64(0xa81a664b, 0xbc423001),
      new int64(0xc24b8b70, 0xd0f89791), new int64(0xc76c51a3, 0x0654be30),
      new int64(0xd192e819, 0xd6ef5218), new int64(0xd6990624, 0x5565a910),
      new int64(0xf40e3585, 0x5771202a), new int64(0x106aa070, 0x32bbd1b8),
      new int64(0x19a4c116, 0xb8d2d0c8), new int64(0x1e376c08, 0x5141ab53),
      new int64(0x2748774c, 0xdf8eeb99), new int64(0x34b0bcb5, 0xe19b48a8),
      new int64(0x391c0cb3, 0xc5c95a63), new int64(0x4ed8aa4a, 0xe3418acb),
      new int64(0x5b9cca4f, 0x7763e373), new int64(0x682e6ff3, 0xd6b2b8a3),
      new int64(0x748f82ee, 0x5defb2fc), new int64(0x78a5636f, 0x43172f60),
      new int64(0x84c87814, 0xa1f0ab72), new int64(0x8cc70208, 0x1a6439ec),
      new int64(0x90befffa, 0x23631e28), new int64(0xa4506ceb, 0xde82bde9),
      new int64(0xbef9a3f7, 0xb2c67915), new int64(0xc67178f2, 0xe372532b),
      new int64(0xca273ece, 0xea26619c), new int64(0xd186b8c7, 0x21c0c207),
      new int64(0xeada7dd6, 0xcde0eb1e), new int64(0xf57d4f7f, 0xee6ed178),
      new int64(0x06f067aa, 0x72176fba), new int64(0x0a637dc5, 0xa2c898a6),
      new int64(0x113f9804, 0xbef90dae), new int64(0x1b710b35, 0x131c471b),
      new int64(0x28db77f5, 0x23047d84), new int64(0x32caab7b, 0x40c72493),
      new int64(0x3c9ebe0a, 0x15c9bebc), new int64(0x431d67c4, 0x9c100d4c),
      new int64(0x4cc5d4be, 0xcb3e42b6), new int64(0x597f299c, 0xfc657e2a),
      new int64(0x5fcb6fab, 0x3ad6faec), new int64(0x6c44198c, 0x4a475817)];

  var W = new Array(64);
  var a, b, c, d, e, f, g, h, i, j;
  var T1, T2;
  var charsize = 8;

  function utf8_encode(str) {
    return unescape(encodeURIComponent(str));
  }

  function str2binb(str) {
    var bin = [];
    var mask = (1 << charsize) - 1;
    var len = str.length * charsize;

    for (var i = 0; i < len; i += charsize) {
      bin[i >> 5] |= (str.charCodeAt(i / charsize) & mask) << (32 - charsize - (i % 32));
    }

    return bin;
  }

  function binb2hex(binarray) {
    var hex_tab = "0123456789abcdef";
    var str = "";
    var length = binarray.length * 4;
    var srcByte;

    for (var i = 0; i < length; i += 1) {
      srcByte = binarray[i >> 2] >> ((3 - (i % 4)) * 8);
      str += hex_tab.charAt((srcByte >> 4) & 0xF) + hex_tab.charAt(srcByte & 0xF);
    }

    return str;
  }

  function safe_add_2(x, y) {
    var lsw, msw, lowOrder, highOrder;

    lsw = (x.lowOrder & 0xFFFF) + (y.lowOrder & 0xFFFF);
    msw = (x.lowOrder >>> 16) + (y.lowOrder >>> 16) + (lsw >>> 16);
    lowOrder = ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);

    lsw = (x.highOrder & 0xFFFF) + (y.highOrder & 0xFFFF) + (msw >>> 16);
    msw = (x.highOrder >>> 16) + (y.highOrder >>> 16) + (lsw >>> 16);
    highOrder = ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);

    return new int64(highOrder, lowOrder);
  }

  function safe_add_4(a, b, c, d) {
    var lsw, msw, lowOrder, highOrder;

    lsw = (a.lowOrder & 0xFFFF) + (b.lowOrder & 0xFFFF) + (c.lowOrder & 0xFFFF) + (d.lowOrder & 0xFFFF);
    msw = (a.lowOrder >>> 16) + (b.lowOrder >>> 16) + (c.lowOrder >>> 16) + (d.lowOrder >>> 16) + (lsw >>> 16);
    lowOrder = ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);

    lsw = (a.highOrder & 0xFFFF) + (b.highOrder & 0xFFFF) + (c.highOrder & 0xFFFF) + (d.highOrder & 0xFFFF) + (msw >>> 16);
    msw = (a.highOrder >>> 16) + (b.highOrder >>> 16) + (c.highOrder >>> 16) + (d.highOrder >>> 16) + (lsw >>> 16);
    highOrder = ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);

    return new int64(highOrder, lowOrder);
  }

  function safe_add_5(a, b, c, d, e) {
    var lsw, msw, lowOrder, highOrder;

    lsw = (a.lowOrder & 0xFFFF) + (b.lowOrder & 0xFFFF) + (c.lowOrder & 0xFFFF) + (d.lowOrder & 0xFFFF) + (e.lowOrder & 0xFFFF);
    msw = (a.lowOrder >>> 16) + (b.lowOrder >>> 16) + (c.lowOrder >>> 16) + (d.lowOrder >>> 16) + (e.lowOrder >>> 16) + (lsw >>> 16);
    lowOrder = ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);

    lsw = (a.highOrder & 0xFFFF) + (b.highOrder & 0xFFFF) + (c.highOrder & 0xFFFF) + (d.highOrder & 0xFFFF) + (e.highOrder & 0xFFFF) + (msw >>> 16);
    msw = (a.highOrder >>> 16) + (b.highOrder >>> 16) + (c.highOrder >>> 16) + (d.highOrder >>> 16) + (e.highOrder >>> 16) + (lsw >>> 16);
    highOrder = ((msw & 0xFFFF) << 16) | (lsw & 0xFFFF);

    return new int64(highOrder, lowOrder);
  }

  function maj(x, y, z) {
    return new int64(
      (x.highOrder & y.highOrder) ^ (x.highOrder & z.highOrder) ^ (y.highOrder & z.highOrder),
      (x.lowOrder & y.lowOrder) ^ (x.lowOrder & z.lowOrder) ^ (y.lowOrder & z.lowOrder)
    );
  }

  function ch(x, y, z) {
    return new int64(
      (x.highOrder & y.highOrder) ^ (~x.highOrder & z.highOrder),
      (x.lowOrder & y.lowOrder) ^ (~x.lowOrder & z.lowOrder)
    );
  }

  function rotr(x, n) {
    if (n <= 32) {
      return new int64(
       (x.highOrder >>> n) | (x.lowOrder << (32 - n)),
       (x.lowOrder >>> n) | (x.highOrder << (32 - n))
      );
    } else {
      return new int64(
       (x.lowOrder >>> n) | (x.highOrder << (32 - n)),
       (x.highOrder >>> n) | (x.lowOrder << (32 - n))
      );
    }
  }

  function sigma0(x) {
    var rotr28 = rotr(x, 28);
    var rotr34 = rotr(x, 34);
    var rotr39 = rotr(x, 39);

    return new int64(
      rotr28.highOrder ^ rotr34.highOrder ^ rotr39.highOrder,
      rotr28.lowOrder ^ rotr34.lowOrder ^ rotr39.lowOrder
    );
  }

  function sigma1(x) {
    var rotr14 = rotr(x, 14);
    var rotr18 = rotr(x, 18);
    var rotr41 = rotr(x, 41);

    return new int64(
      rotr14.highOrder ^ rotr18.highOrder ^ rotr41.highOrder,
      rotr14.lowOrder ^ rotr18.lowOrder ^ rotr41.lowOrder
    );
  }

  function gamma0(x) {
    var rotr1 = rotr(x, 1), rotr8 = rotr(x, 8), shr7 = shr(x, 7);

    return new int64(
      rotr1.highOrder ^ rotr8.highOrder ^ shr7.highOrder,
      rotr1.lowOrder ^ rotr8.lowOrder ^ shr7.lowOrder
    );
  }

  function gamma1(x) {
    var rotr19 = rotr(x, 19);
    var rotr61 = rotr(x, 61);
    var shr6 = shr(x, 6);

    return new int64(
      rotr19.highOrder ^ rotr61.highOrder ^ shr6.highOrder,
      rotr19.lowOrder ^ rotr61.lowOrder ^ shr6.lowOrder
    );
  }

  function shr(x, n) {
    if (n <= 32) {
      return new int64(
       x.highOrder >>> n,
       x.lowOrder >>> n | (x.highOrder << (32 - n))
      );
    } else {
      return new int64(
       0,
       x.highOrder << (32 - n)
      );
    }
  }

  str = utf8_encode(str);
  var strlen = str.length*charsize;
  str = str2binb(str);

  str[strlen >> 5] |= 0x80 << (24 - strlen % 32);
  str[(((strlen + 128) >> 10) << 5) + 31] = strlen;

  for (var i = 0; i < str.length; i += 32) {
    a = H[0];
    b = H[1];
    c = H[2];
    d = H[3];
    e = H[4];
    f = H[5];
    g = H[6];
    h = H[7];

    for (var j = 0; j < 80; j++) {
      if (j < 16) {
       W[j] = new int64(str[j*2 + i], str[j*2 + i + 1]);
      } else {
       W[j] = safe_add_4(gamma1(W[j - 2]), W[j - 7], gamma0(W[j - 15]), W[j - 16]);
      }

      T1 = safe_add_5(h, sigma1(e), ch(e, f, g), K[j], W[j]);
      T2 = safe_add_2(sigma0(a), maj(a, b, c));
      h = g;
      g = f;
      f = e;
      e = safe_add_2(d, T1);
      d = c;
      c = b;
      b = a;
      a = safe_add_2(T1, T2);
    }

    H[0] = safe_add_2(a, H[0]);
    H[1] = safe_add_2(b, H[1]);
    H[2] = safe_add_2(c, H[2]);
    H[3] = safe_add_2(d, H[3]);
    H[4] = safe_add_2(e, H[4]);
    H[5] = safe_add_2(f, H[5]);
    H[6] = safe_add_2(g, H[6]);
    H[7] = safe_add_2(h, H[7]);
  }

  var binarray = [];
  for (var i = 0; i < H.length; i++) {
    binarray.push(H[i].highOrder);
    binarray.push(H[i].lowOrder);
  }
  
  return binb2hex(binarray);
 }
function existeUrl(url) {
   var http = new XMLHttpRequest();
   http.open('HEAD', url, false);
   http.send();
   return http.status!=404;
 }
function slideDias($obj,dir=0,callback){
	
	if (dir>0||dir=='right'){
		var ent = 'right';
		var sal = 'left';
	}else{
		var ent = 'left';
		var sal = 'right';
	}

	$obj
		.hide("slide", { direction: sal }, 1000,function(){
			// nueva forma de mostrar slider
			$obj.find('.mostrar').removeClass('mostrar').addClass('ocultar')
			$obj.find('.'+Fecha.id).addClass('mostrar').removeClass('ocultar')
			
			// en desuso
			$('table.activa').removeClass('activa')
			$('#'+Fecha.id).addClass('activa')
			$obj
			.show("slide", { direction: ent },1000,function(){
					typeof callback == "function" && callback();
				});
		})

 }
function pad (n, length) {
    var  n = n.toString();
    while(n.length < length)
         n = "0" + n;
    return n;
 }
function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
 }
$(function(){
	$('.time').mask('00:00');
	$('.tel').mask('##000000000');
	$('.date').mask('00/00/0000');
	$('.pin').mask('0000');
	
	jQuery.each(jQuery('textarea[data-autoresize]'), function() {
	var offset = this.offsetHeight - this.clientHeight;

	var resizeTextarea = function(el) {
		jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
	};
	jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
	});
	$(document)
		.keyup(function(event){
			if(event.which==27){
				dialog.close('.dialog');
			}
		})
		.on('click',"html .btnLoad",function(){btn.load.show($(this))})
		.on('click','.icon-eye',function(e){
			var $pass = $(this).siblings('input:password'),
				$text = $(this).siblings('input:text')

				if ($pass.length == 0)
					$text.attr('type','password')
				else
					$pass.attr('type','text')
			e.stopPropagation()
		 })
		.on('change','input:password',function(){
			validar.pass.estado=false
			validar.pass.funcion($(this))
		 })
		.on('blur','.email',function(){validar.email.funcion($(this))})
		.on('change','.email',function(){validar.email.estado=false})
		.on('blur','.tel',function(){validar.tel.funcion($(this))})
		.on('change','.tel',function(){validar.tel.estado=false})
		.on('click','.iconClass-inside.icon-cancel',function(){
			$(this).parent().find('input').val("");
		 })
		.on('blur','.nombre',function(){validar.nombre.funcion($(this))})
		.on('change','.nombre',function(){validar.nombre.estado=false}).end()
		.on('keydown','.input-error',function(){$(this).removeClass('input-error')})
		.on('keydown','.input-success',function(){$(this).removeClass('input-success')})
		.on('click','.inicio',function(){window.location.href="index.php"})
		.on('click','#btnMenuResponsive',function(){
			toggleMetroCharm('#mnuResponsive')
		 })
	$('body')
		.on('click','.clear-input',function(){
			$(this).siblings('input').val('')
		})
	if(!$.isEmpty($_GET['err'])){
		let code = (!$.isEmpty($_GET['cod']))?pad($_GET['cod'],3):''
		notify.error($_GET['err'], 'ERROR:' + code)
	}
})