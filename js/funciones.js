var xhr= null;

var ruta = window.location.pathname;
var arrayNombre = new Array;
arrayNombre = ruta.split("/");
var nombreEmpresa = $('body').data('empresa');

var horarios = new Array();
var festivos = new Array();

$(function(){
	$('.time').mask('00:00');
	$('.tel').mask('## 000 00 00 00');
	$('.date').mask('00/00/0000');
	
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
				popup.close();
				dialog.close('.dialog');
				popup.close();
			}
		})
		.on('click',".btnLoad",function(){btn.load.show($(this))})
		.on('click','.iconClass-inside.icon-eye',function(){
			var $this = $(this).parent().find('input:visible')
			var tipo = $this.attr('type')
			tipo = tipo == 'password'?'text':'password';
			$this.attr('type',tipo)
		})
		.on('blur','input:password',function(){validar.pass.funcion($(this))})
		.on('change','input:password',function(){validar.pass.estado=false})
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
})
jQuery.isEmpty = function(obj){
	var isEmpty =
	typeof obj == 'undefined' || obj === null || obj === false|| obj <1 ||obj === ''?true:
	typeof obj == 'number' && isNaN(obj)?true:
	obj instanceof Date && isNaN(Number(obj))?true:
	obj.length==0;

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
var Fecha = {
	actual: fechaActual(),
	general: formatoFecha(fechaActual(),'sql'),
	id:  formatoFecha(fechaActual(),'number'), //inicializo con fecha actual pero es un id.
	sql: function(fecha){return formatoFecha(fecha,'sql')},
	print: function(fecha){return formatoFecha(fecha,'print')},
	md: function(fecha){return formatoFecha(fecha,'md')},
	number: function(fecha){return formatoFecha(fecha,'number')},
	calcular: function(dia,fecha){return calcularFecha(dia,fecha)},
	diaSemana: function(fecha){
	    var fecha = Fecha.sql(fecha);
		var mdy = fecha.split('-');
		fecha = new Date(mdy[0], mdy[1]-1, mdy[2]);
		return fecha.getDay();
	},
	restar: function (f1,f2){
		var f2  = $.isEmpty(f2)?this.actual:this.sql(f2);
		var f1 = this.sql(f1);
	
		var aFecha1 = f1.split('-');
		var aFecha2 = f2.split('-');
		var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]);
		var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]);
		var dif = fFecha1 - fFecha2 	;

		return Math.floor(dif / (1000 * 60 * 60 * 24));
	},
}
var btn = {
	active : null , 
	load : {
		status: true, //variable para impedir que aparezca el load en los botones si esta en falso.

		show : function($this, status){

			if (btn.load.status){
					$this.html('<span class="icon-load animate-spin"></span>');
					btn.active = $this ;
			}
			
			btn.load.status = (status != 'undefined') ? status : true;	

		},
		hide : function(btnId){
			var $this = btnId||btn.active //$('.icon-load:visible').parent();

			var caption = $this.data('value');
			
			$this.html(caption);	
			btn.active = null ;		
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
							caption: 'Nombre de usuario',
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
				}else{
					$this.addClass('input-error')
					validar.tel.estado =  false;
				}
			}else{
				$this.val('');
			}
		},
		estado: true,
	},
	pass: {
		funcion:function($this){
			if ($this.val()=="") return false;
			var pass = $this.val();
			if(pass.length>6){
				var pass = SHA1($this.val());
				var $hidden_pass = $this.siblings('input:hidden');
				$hidden_pass.val(pass);
				$this.addClass('input-success');

				var $pass = $(':password');
				
				//esto solo es para cuando se quiere cambiar la contraseña desde config 
				var n = ($this.parents('#dlgCambiarPass').length>0)?1:0;

				if ($pass.length>1){
					if ($this.attr('id') === $pass.eq(n+1).attr('id'))
					if ($pass.eq(n+1).val()!=$pass.eq(n).val()&&$pass.eq(n+1).val()!=""){
						$.Notify({
							id:'lblPassNC',
							type: 'warning',
							caption: 'Repetir contraseña',
							content: 'Las contraseñas no coinciden.',
							icon:'icon-lock'
						})
						$this
							.addClass('input-error')
							.removeClass('input-success');
						validar.pass.estado =  false;
					}else{
						$this
							.addClass('input-success')
							.removeClass('input-error');
						validar.pass.estado =  true;
					}
				}
			}else{
				if(!$this.hasClass('input-error')){
					$.Notify({
						id:'lblPass',
						type: 'warning',
						caption: 'Contraseña',
						content: 'Tiene que tener más de 6 carácteres.',
						icon:'icon-lock'
					})
					$this.addClass('input-error');
				}
				validar.pass.estado =  false;
			}
		},
		estado: false,
	},	
	form : function(idFrm){
//AKI :: personalizando mensaje de error 
		var frm = $('#'+idFrm);

		if (frm[0].checkValidity(opts) != false){
			return true; 
		}else{
			notify.error(frm[0].validationMessage,'Error formulario')
			return false ;
		}		

	},
}
var popup  ={
	open: function(id){
			$this = $(id);
			btn.load.reset();
			$this.fadeIn('slow');
			$('.popup-overlay').fadeIn('slow');
		},
	close: function(){
			btn.load.reset(function(){
				$('body').css('overflow','scroll');
				$('.popup').fadeOut('slow');
				$('.popup-overlay').fadeOut('slow');
			});
		},
	create: function (objName,callback){
		var $this = $('#'+objName);
		if(!$this.length){
			 var url = '../../php/admin/dialogs/'+objName+'.html'
			 $.get(url,function(html){
				 $('#dialogs').append(html)
				 typeof callback == "function" && callback();
			 })
		}else{
			if ($this.find('form').length)
				$this.find('form')[0].reset()
			typeof callback == "function" && callback();
		}
	},
}
var dialog = {
	open:function(idObj,fnOk,fnCancel,callback){
		btn.load.reset();

		var $this = $(idObj);
		if(!$this.find('.icon-cancel').length){
			if($this.hasClass('dialog')){
				$this.prepend('<span class="icon-cancel"></span>')
			}
			$this.find('.icon-cancel').click(function(){
				dialog.close(idObj)
			})
			$this.find('.cancelar')
				.click(function(e){
					typeof fnCancel == "function"?fnCancel():dialog.close(idObj);
				})
			$this.find('.aceptar')
				.click(function(e){
					if(typeof fnOk == "function")fnOk();
				})
		}

		$this.show();
		$('.popup-overlay').fadeIn();

		var $load = $this.find('.btnLoad');
		if($load.length){
			$load.each(function(){
				var caption = $(this).data('value');
				$(this).html(caption)
			})
		}

			typeof callback == "function" && callback();
	},
	close:function (idObj,callback){
		var $this = $(idObj);
		$this.fadeOut().hide();
		$('#dialogs').fadeOut().hide();

		typeof callback == "function" && callback();
	},
	create: function (objName,callback){
		var $this = $('#dialogs #'+objName);
		if(!$this.length){
			 var url = '../../php/admin/dialogs/'+objName+'.html'
			 $.get(url,function(html){
				$('#dialogs')
					.append(html)
					.promise()
					.done(function(){
						$this = $('#dialogs #'+objName)
							.keypress(function(e){
									var code = e.keyCode || e.which;
								//BOTON PREDETERMINADO EN LOS DIALOGS
									if(event.which==13)
										$this.find('.aceptar').click();

							})
							.find("form:not(.filter) :input:visible:enabled:first").focus();
//AKI : no consigo pasar el foco 
					typeof callback == "function" && callback();

					})
			 })
		}else{
			if ($this.find('form').length)
				$this.find('form')[0].reset()
			typeof callback == "function" && callback();
		}
	}
}
var notify = {
	success: function(mns,cptn, keep){
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
	},
	error: function(mns,cptn,keep){
		var keepOpen = keep||false;
		var cptn = cptn||'Error';
		var mns = mns||'Ha sucedido un error';
		$.Notify({
			type: 'alert',
			caption: cptn,
			content: mns,
			icon: 'icon-cross',
			keepOpen: keep,
		})
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
function formatoFecha (fechaTxt,formatOut){

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
		prevText: '<Ant',
		nextText: 'Sig>',
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
			var day = date.getDay();
			return day == 0 ||$.inArray(current,  document.festivos) > -1?[fesOn, "festivo"]:[true, ""];
		},
		onSelect: function (fecha) {
			sincronizar(null, fecha);
			$('.ui-datepicker-inline').html(fecha);//para usuarios
		},
		onClose: function(){
			this.blur();
		},
		defaultDate: Fecha.print(Fecha.general)|| new Date(),
		showAnim: 'blind',
	});
	$dp.each(function(){$(this).val(formatoFecha(Fecha.general,'print'))})
	typeof callback == "function" && callback();
};
function calcularFecha(days, fecha){
	var fecha = fecha||Fecha.general;
	fecha= "undefined"==fecha?Fecha.general:fecha;
	var mdy = fecha.split('-');
	fecha = new Date(mdy[0], mdy[1]-1, mdy[2]);

    milisegundos=parseInt(35*24*60*60*1000);

    day=fecha.getDate();
    // el mes es devuelto entre 0 y 11
    month=fecha.getMonth()+1;
    year=fecha.getFullYear();
    //Obtenemos los milisegundos desde media noche del 1/1/1970
    tiempo=fecha.getTime();
    //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
    milisegundos=parseInt(days*24*60*60*1000);
    //Modificamos la fecha actual
    total=fecha.setTime(tiempo+milisegundos);
    day=fecha.getDate();
    month=fecha.getMonth()+1;
    year=fecha.getFullYear();
	return  year+"-"+month+"-"+day;
}
function colorearMenuDiasSemana(arg){
	var fecha = arg||Fecha.general;
	$('.highlighted').removeClass('highlighted');
	var f = new Date();
	f = formatoFecha(fecha);
	var d = f.getDay() !=0?f.getDay():7;
	$("#mainLstDiasSemana #mainMenu"+d).addClass("highlighted");

	$("#lstDiasSemana").val(d);

	//coloreo rojo festivos en datepicker
	var fes = formatoFecha(fecha,'md');
	if(d==7||$.inArray(fes,festivos.year)!=-1)
		$('.datepicker').css('color','#e04747')
	else
		$('.datepicker').css('color','inherit')
	

};
function hideShow(param){
	for (var i = 0; i < arguments.length; ++i) {
			let $obj = $(arguments[i])
			$obj.toggle();
	}
}
function normalize(string){
	var str = string.split(" ").join("_");
	if ($.isEmpty(str))return false;
	var map={
		'À':'A','Á':'A','Â':'A','Ã':'A','Ä':'A','Å':'A','Æ':'AE','Ç':'C','È':'E','É':'E','Ê':'E','Ë':'E','Ì':'I','Í':'I','Î':'I','Ï':'I','Ð':'D','Ñ':'N','Ò':'O','Ó':'O','Ô':'O','Õ':'O','Ö':'O','Ø':'O','Ù':'U','Ú':'U','Û':'U','Ü':'U','Ý':'Y','ß':'s','à':'a','á':'a','â':'a','ã':'a','ä':'a','å':'a','æ':'ae','ç':'c','è':'e','é':'e','ê':'e','ë':'e','ì':'i','í':'i','î':'i','ï':'i','ñ':'n','ò':'o','ó':'o','ô':'o','õ':'o','ö':'o','ø':'o','ù':'u','ú':'u','û':'u','ü':'u','ý':'y','ÿ':'y','Ā':'A','ā':'a','Ă':'A','ă':'a','Ą':'A','ą':'a','Ć':'C','ć':'c','Ĉ':'C','ĉ':'c','Ċ':'C','ċ':'c','Č':'C','č':'c','Ď':'D','ď':'d','Đ':'D','đ':'d','Ē':'E','ē':'e','Ĕ':'E','ĕ':'e','Ė':'E','ė':'e','Ę':'E','ę':'e','Ě':'E','ě':'e','Ĝ':'G','ĝ':'g','Ğ':'G','ğ':'g','Ġ':'G','ġ':'g','Ģ':'G','ģ':'g','Ĥ':'H','ĥ':'h','Ħ':'H','ħ':'h','Ĩ':'I','ĩ':'i','Ī':'I','ī':'i','Ĭ':'I','ĭ':'i','Į':'I','į':'i','İ':'I','ı':'i','Ĳ':'IJ','ĳ':'ij','Ĵ':'J','ĵ':'j','Ķ':'K','ķ':'k','Ĺ':'L','ĺ':'l','Ļ':'L','ļ':'l','Ľ':'L','ľ':'l','Ŀ':'L','ŀ':'l','Ł':'L','ł':'l','Ń':'N','ń':'n','Ņ':'N','ņ':'n','Ň':'N','ň':'n','ŉ':'n','Ō':'O','ō':'o','Ŏ':'O','ŏ':'o','Ő':'O','ő':'o','Œ':'OE','œ':'oe','Ŕ':'R','ŕ':'r','Ŗ':'R','ŗ':'r','Ř':'R','ř':'r','Ś':'S','ś':'s','Ŝ':'S','ŝ':'s','Ş':'S','ş':'s','Š':'S','š':'s','Ţ':'T','ţ':'t','Ť':'T','ť':'t','Ŧ':'T','ŧ':'t','Ũ':'U','ũ':'u','Ū':'U','ū':'u','Ŭ':'U','ŭ':'u','Ů':'U','ů':'u','Ű':'U','ű':'u','Ų':'U','ų':'u','Ŵ':'W','ŵ':'w','Ŷ':'Y','ŷ':'y','Ÿ':'Y','Ź':'Z','ź':'z','Ż':'Z','ż':'z','Ž':'Z','ž':'z','ſ':'s','ƒ':'f','Ơ':'O','ơ':'o','Ư':'U','ư':'u','Ǎ':'A','ǎ':'a','Ǐ':'I','ǐ':'i','Ǒ':'O','ǒ':'o','Ǔ':'U','ǔ':'u','Ǖ':'U','ǖ':'u','Ǘ':'U','ǘ':'u','Ǚ':'U','ǚ':'u','Ǜ':'U','ǜ':'u','Ǻ':'A','ǻ':'a','Ǽ':'AE','ǽ':'ae','Ǿ':'O','ǿ':'o'
	};
	var res=''; //Está variable almacenará el valor de str, pero sin acentos y tildes
	for (var i=0;i<str.length;i++){
		c=str.charAt(i);res+=map[c]||c;
	}
	res =
		res
		.replace(/\s/g, "")
		.toLowerCase()
		.trim();
	return res;

};
function $_GET(param){

		/* Obtener la url completa */
		var url = document.URL;
		/* Buscar a partir del signo de interrogación ? */
		url = String(url.match(/\?+.+/));
		/* limpiar la cadena quitándole el signo ? */
		url = url.replace("?", "");
		/* Crear un array con parametro=valor */
		url = url.split("&");

		/*
		Recorrer el array url
		obtener el valor y dividirlo en dos partes a través del signo =
		0 = parametro
		1 = valor
		Si el parámetro existe devolver su valor
		*/
		x = 0;
		while (x < url.length){
			p = url[x].split("=");
			if (p[0] == param)
			{
				return decodeURIComponent(p[1]);
			}
			x++;
		}
};
function echo(d){
	console.log(d);
}
function SHA1(msg) {
  function rotate_left(n,s) {
    var t4 = ( n<<s ) | (n>>>(32-s));
    return t4;
  };
  function lsb_hex(val) {
    var str="";
    var i;
    var vh;
    var vl;
    for( i=0; i<=6; i+=2 ) {
      vh = (val>>>(i*4+4))&0x0f;
      vl = (val>>>(i*4))&0x0f;
      str += vh.toString(16) + vl.toString(16);
    }
    return str;
  };
  function cvt_hex(val) {
    var str="";
    var i;
    var v;
    for( i=7; i>=0; i-- ) {
      v = (val>>>(i*4))&0x0f;
      str += v.toString(16);
    }
    return str;
  };
  function Utf8Encode(string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";
    for (var n = 0; n < string.length; n++) {
      var c = string.charCodeAt(n);
      if (c < 128) {
        utftext += String.fromCharCode(c);
      }
      else if((c > 127) && (c < 2048)) {
        utftext += String.fromCharCode((c >> 6) | 192);
        utftext += String.fromCharCode((c & 63) | 128);
      }
      else {
        utftext += String.fromCharCode((c >> 12) | 224);
        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
        utftext += String.fromCharCode((c & 63) | 128);
      }
    }
    return utftext;
  };
  var blockstart;
  var i, j;
  var W = new Array(80);
  var H0 = 0x67452301;
  var H1 = 0xEFCDAB89;
  var H2 = 0x98BADCFE;
  var H3 = 0x10325476;
  var H4 = 0xC3D2E1F0;
  var A, B, C, D, E;
  var temp;
  msg = Utf8Encode(msg);
  var msg_len = msg.length;
  var word_array = new Array();
  for( i=0; i<msg_len-3; i+=4 ) {
    j = msg.charCodeAt(i)<<24 | msg.charCodeAt(i+1)<<16 |
    msg.charCodeAt(i+2)<<8 | msg.charCodeAt(i+3);
    word_array.push( j );
  }
  switch( msg_len % 4 ) {
    case 0:
      i = 0x080000000;
    break;
    case 1:
      i = msg.charCodeAt(msg_len-1)<<24 | 0x0800000;
    break;
    case 2:
      i = msg.charCodeAt(msg_len-2)<<24 | msg.charCodeAt(msg_len-1)<<16 | 0x08000;
    break;
    case 3:
      i = msg.charCodeAt(msg_len-3)<<24 | msg.charCodeAt(msg_len-2)<<16 | msg.charCodeAt(msg_len-1)<<8  | 0x80;
    break;
  }
  word_array.push( i );
  while( (word_array.length % 16) != 14 ) word_array.push( 0 );
  word_array.push( msg_len>>>29 );
  word_array.push( (msg_len<<3)&0x0ffffffff );
  for ( blockstart=0; blockstart<word_array.length; blockstart+=16 ) {
    for( i=0; i<16; i++ ) W[i] = word_array[blockstart+i];
    for( i=16; i<=79; i++ ) W[i] = rotate_left(W[i-3] ^ W[i-8] ^ W[i-14] ^ W[i-16], 1);
    A = H0;
    B = H1;
    C = H2;
    D = H3;
    E = H4;
    for( i= 0; i<=19; i++ ) {
      temp = (rotate_left(A,5) + ((B&C) | (~B&D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    for( i=20; i<=39; i++ ) {
      temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    for( i=40; i<=59; i++ ) {
      temp = (rotate_left(A,5) + ((B&C) | (B&D) | (C&D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    for( i=60; i<=79; i++ ) {
      temp = (rotate_left(A,5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
      E = D;
      D = C;
      C = rotate_left(B,30);
      B = A;
      A = temp;
    }
    H0 = (H0 + A) & 0x0ffffffff;
    H1 = (H1 + B) & 0x0ffffffff;
    H2 = (H2 + C) & 0x0ffffffff;
    H3 = (H3 + D) & 0x0ffffffff;
    H4 = (H4 + E) & 0x0ffffffff;
  }
  var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);

  return temp.toLowerCase();
}
function existeUrl(url) {
   var http = new XMLHttpRequest();
   http.open('HEAD', url, false);
   http.send();
   return http.status!=404;
}
function slideDias(contenedor,dir,callback){
	var idFecha = Fecha.number(Fecha.general);
	var 	dir= dir||0;
	if (dir>0||dir=='right'){
		var ent = 'right';
		var sal = 'left';
	}else{
		var ent = 'left';
		var sal = 'right';
	}

	contenedor
		.hide("slide", { direction: sal }, 750,function(){
			$('table.activa').removeClass('activa')
			$('#'+Fecha.id).addClass('activa')
			contenedor
				.show("slide", { direction: ent }, 750,function(){
					typeof callback == "function" && callback();
				});
		})

}
