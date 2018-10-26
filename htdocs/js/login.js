const 
	EMPRESA = $('body').data('empresa'), 
	URL = 'app.php?empresa='+$('body').data('empresa')
var 
main = {  
	scripts : {
		loaded: ['secLogin'],
		isLoaded : function(arg){this.loaded.includes(arg)}, 
		load : function(arg, callback){
			if(typeof arg == 'undefined') return false;
			if(!this.loaded.includes(arg)){
				this.loaded.push(arg)

				$.getScript('/js/min/'+arg+'.js',function(){
					typeof window[arg].init == 'function' && window[arg].init();
					typeof callback == 'function' && callback();
				});
			} else 	{

				typeof window[arg].init() == 'function' && window[arg].init()
				typeof callback == 'function' && callback()
			}
		},
	 }, 
	dir1 : RIGHT, 
	dir2 : LEFT,
	toggle : function($in, container){
		var $out = $('section:visible'),
			nameId = $in.selector.replace('#',''), 
			$container = $('#'+container);
			
		if(main.scripts.loaded.indexOf(nameId)==-1){
			//Cargo el id en la variable para saber cuales estan cargados
			
			main.scripts.loaded[main.scripts.length] = nameId
			if (nameId == 'newUser') main.scripts.loaded[main.scripts.loaded.length] = 'secNewNotification'; 
			var data = {
				controller: 'login',
				view: nameId
			}

			$.post(URL,data,function(html){
				$container.html(html); 
				cube.goTo(container); 
			},'html'); 
		} else 
			cube.goTo(container);

	 }, 
	loader : {
		show : function(){
			$('main').find('#loading').removeClass('hidden')
		 },
		hide: function(){
			$('main').find('#loading').addClass('hidden')
		 }
	 }, 
	logout : function(){	
		let effect = 'puff'; 
		$('body')
			.hide(effect,function(){
				$(this)
					.addClass('background-personalized')
					.empty()	
					.html(login.html)
					.show(effect);
			})
		 $.post(INDEX, {controller : 'logout'});
	}
 }, 
login = {
	isLoad : true, 
	block : false, 
	html : '', 
	setCookie : ()=>{
		localStorage.setItem("AOLAvisoCookie", 1);
		document.getElementById("barraaceptacion").style.display="none";
	 }, 
	send : {
		validate : function(data){ 
			if(!login.block){
				login.block = true
				btn.loader.show()

				$.post(INDEX, data, function(r){
					if (r.error == undefined){
						// Si estoy cargando newpinpass que me lo cargue detras de cube 
						// para mantener estetica
						if($(r).find('#newpinpass').length){
							$('#back').html(r); 
							cube.goTo('back'); 
						}else{

							// Devuelve zona admin o users  logueo correcto
							btn.load.hide();
							//Filtro por si viene de nuevo pin 
							// devuelvo entrada de pin normal
							if($('body').find('#newpinpass').length){
									let data = {
										controller : 'login', 
										view : 'pinpass'
									}
								$.post(INDEX,data,function(r){
									login.html = r
								},'html')
							} else { 
								login.html = $('body').html(); 
							}
							$('body > *').detach();
							$('body')
								.append(r)
								.removeClass()
							let section = $(r).filter('main').attr('id');

							main.scripts.load(section)
						}
					} else { 
						let res = r.error.split("<br>")
						notify.error(res[1], res[0], 5000);
					}
				})
				.always(function() {
					login.block = false;
					btn.loader.hide()
				});
			}
		}
	 }
 }, 
recover = {
	send : function (callback){
		var data = {
			email : $('#recover').find('#email').val(),
			controller : 'login',
			action : 'recover'
	  	 }

		$.post(URL, data,function (r) {
			if (r.success) {
				notify.success('Siga las instrucciones del email', 'Email enviado')
				
			} else {
				notify.error(r.err, 'Error: '+ r.code)
				echo(r);
			 }	
			btn.load.hide()
		 },'json')	
	 }
 }, 
user = {
	save : function () {
		$('#frmNewUSer #pass').val(Tools.SHA$(('#frmNewUSer #fakePass').val()))
		var	data = $("#frmNewUSer").serializeArray()			
			data.push({name : 'controller' , value:'login'})
			data.push({name : 'action' , value : SAVE})
		$.post(URL, data,function (r) {
			if (r.success) {
				notify.success('Su usuario ha sido guardado', 'Registro aceptado')
				user.notification()
			} else {
				
				notify.error(r.err, 'Error: '+ r.code)
				echo(r);
				}	
			btn.load.hide()
		},'json');	
			
	 },
	notification: function(){
	//AKI :: 	main.toggle($('#secNewNotification'))
	 }
 },
validate = {
	login :function() {
			var $pass = $('#pass'), 
				$email = $('#login')
				
		if ($.isEmpty($pass.val())|| $pass.val() < 6){
			$pass.addClass('input-error')
			return false
		 }
		return true;
	 }, 
	pass : function (pass1, pass2) {
		if (!$.isEmpty(pass1) && pass1 === pass2){
			if (pass1.length < 6 ) {
				notify.error('El password debe de ser de 6 caracteres mínimo','Password invalido') 
				return false
			}
		} else {
			notify.error('Los passwords no coinciden','Password invalido') 
			$('#passR').removeClass('input-success').addClass('input-error')
			return false
		}
		return true
	 }
 }

$(function(){
	$('body')
		.find('form button').prop('disabled',false).end()	
		.on('click','#btnbarraaceptacion',login.setCookie)
		.on('submit','#loginUsuario ',function(e){
			e.preventDefault()

			if (localStorage.getItem('AOLAvisoCookie')!=1) {
				alert("Debes autorizar el uso de las cookies para poder continuar usando la aplicacion")
				btn.load.hide()
				return false
			}
			let data ={
				controller : 'validar', 
				ancho : screen.width , 
				login : $(this).find('#login').val(), 
				pass : Tools.SHA($(this).find('#pass_login').val()), 
				recordar : $(this).find('#recordar').is(':checked'), 
				empresa : normalize(config.nombre_empresa)
			}
					
			login.send.validate(data) ;
	
		 })
		.on('submit','#newpinpass ',function(e){
			e.preventDefault()

			if (localStorage.getItem('AOLAvisoCookie')!=1) {
				alert("Debes autorizar el uso de las cookies para poder continuar usando la aplicacion")
				btn.load.hide()
				return false
			}
			let data ={
				controller : 'newPin', 
				newpinpass: $(this).find('#newpinpass').val(),
				action: 'validate',
				empresa : normalize(config.nombre_empresa)
			}
					
			login.send.validate(data);
		})
		.on('click','.cancel',function(e){
			cube.goTo("front")
		 })
		.on('click','#aNewUser',function(){
			main.toggle($('#newUser'),'right')
		 })
		.on('submit','#frmNewUSer',function(e){
			e.preventDefault()
			if (validate.pass($('input#pass').val(), $('input#passR').val()))
				user.save()
		 })
		.on('click','#forgotPass',function(){
			main.toggle($('#recover'), 'left')
		 })
		.on('submit','#recover form',function(e){
			e.preventDefault()
			recover.send(
				()=>main.toggle($('#newPass'),'back')
			)
					
		 })
		.on('click','.logout',function(){
			deleteAllCookies();
		 })
		.on('keyup','#pinpass',function(e){
			e.preventDefault();
			let pin = $(this).val(); 
			if(pin.length == 4) {
			
				let data ={
					controller : 'validar', 
					pinpass : pin, 
					empresa : normalize(config.nombre_empresa)
				}
				$(this).val('');	
				login.send.validate(data) ;
			} else 
			if(pin.length > 4){
				$(this).val('');
				notify.error('Pin no puede ser mayor de 4 digitos', 'ERROR PIN MAYOR 4!!'); 
			}
		 })

	if(!$.isEmpty($_GET['args'])){
		let code = (!$.isEmpty($_GET['cod']))?('000' + $_GET['cod']).slice (-3):''; 
		if(!$.isEmpty($_GET['err']))
			notify.error($_GET['err'], 'ERROR:' + code)
	 } 
	if(!$.isEmpty($_GET['success']))
			notify.success($_GET['success'])

	// Si hay error de autentificacion esta en el div#errors 
	let textError = $('div#notify').text();
	if(!$.isEmpty(textError)){
		notify.error(textError)
		//$('div#errors').text('')
	}

	$('#frmLogin')
		.keyup(function(e){
			if(e.keyCode == 13)$('#btnLogin').click()
		 })
		.submit(function(e){
			if (!validate.login()) {
				e.preventDefault()  
				btn.load.hide()
			}
		 })

	//para poder recoger los get en el login se muestran en la 5 barra de la url amigable
	//if(error.get()) notify.error(error.mns)
	$('#login.email').focus()

	//BLOQUE DE COOKIES
	if(localStorage.getItem('AOLAvisoCookie')!=1){
		document.getElementById("barraaceptacion").style.display="block";
	}
	
	login.html = $('main')
 })