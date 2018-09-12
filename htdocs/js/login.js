const 
	EMPRESA = $('body').data('empresa'), 
	URL = 'app.php?empresa='+$('body').data('empresa')
var general = {  
	loaded : ['secLogin'],
	dir1 : RIGHT, 
	dir2 : LEFT, 
	toggle : function($in){
		var $out = $('section:visible'),
			_toggle = function($in){
				$out.hide('drop',{direction:general.dir1},function(){
					var id = $in.attr('id')
					$('#'+id)
						.show('drop',{direction:general.dir2})

						if(general.dir1 == RIGHT){
							general.dir1 = LEFT
							general.dir2 = RIGHT
						} else {
							general.dir1 = RIGHT
							general.dir2 = LEFT
						}
				})
			},
			nameId = $in.selector.replace('#',''); 

		if(general.loaded.indexOf(nameId)==-1){
			//Cargo el id en la variable para saber cuales estan cargados
			
			general.loaded[general.loaded.length] = nameId
			if (nameId == 'newUser') general.loaded[general.loaded.length] = 'secNewNotification'
			var data = {
				controller: 'login',
				view: nameId
			}

			$.post(URL,data,function(html){
				$('.login').prepend(html)
				$(html)	.attr('class','')
				_toggle($(html))

			},'html')
		} else {
			_toggle($in)
		}

	 }
 }
var error = function (mns){
	$('#loginUsuarioPopoverTxt').html(mns)
	$('#frmLogin')
		.popover('show')
		.find('input')
			.each(function(){
				$(this).addClass('input-error');
			})
 }
let 
Login = {
	isLoad : true, 
	html : '', 
	setCookie : ()=>{
		localStorage.setItem("AOLAvisoCookie", 1);
		document.getElementById("barraaceptacion").style.display="none";
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
		general.toggle($('#secNewNotification'))
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
			$('#fakePassR').removeClass('input-success').addClass('input-error')
			return false
		}
		return true
	 }
 }

$(function(){

	$('body')
		// Logueamos usuarios y cargamos vista correspondiente 
		.on('click','#btnbarraaceptacion',Login.setCookie)
		.find('form button').prop('disabled',false).end()	
		.on('submit','#loginUsuario',function(e){
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
				pass : Tools.SHA($(this).find('#pass').val()), 
				recordar : $(this).find('#recordar').is(':checked'), 
				empresa : normalize(config.nombre_empresa)
			}
					
			$.post(INDEX, data, function(r){

				if (r.error == undefined){
					// Devuelve zona admin o users  logueo correcto
					Login.html = $('#login').detach()
					$('body')
						.append(r)
						.removeClass()
					let section = $(r).filter('main').attr('id');
					$.getScript('js/'+section+'.js');
				} else { 
					let res = r.error.split("<br>")
					notify.error(res[1], res[0], 5000);
				}
			})
		 })
		.on('click','.cancel',function(e){
			general.toggle($('#secLogin'))
		 })
		.on('click','#aNewUser',function(){
			general.toggle($('#newUser'))
		 })
		.on('submit','#frmNewUSer',function(e){
			e.preventDefault()
			if (validate.pass($('input#fakePass').val(), $('input#fakePassR').val()))
				user.save()
		 })
		.on('click','#forgotPass',function(){
			general.toggle($('#recover'))
		 })
		.on('submit','#recover form',function(e){
			e.preventDefault()
			
			recover.send(
				()=>general.toggle($('#newPass'))
			)
					
		 })
		.on('click','.logout',function(){
			deleteAllCookies();
			location.href = '/'+EMPRESA + '';
		 })
		.on('keyup','#pinpass',function(){
			pin = $(this).val()
			if(pin.length == 4) $('#frmPinpass').submit()
		 })

	if(!$.isEmpty($_GET['args'])){
		let code = (!$.isEmpty($_GET['cod']))?pad($_GET['cod'],3):''
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
	

 })