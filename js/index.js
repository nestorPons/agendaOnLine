$('#nuevoUsuario form').submit(function(e){
	e.preventDefault();
})
//$('#fb-facebookLogin').click(loginFace);
$('#cambiarPass').click(cambiarPass);
$('#loginUsuario').keyup(function(e){
	 if(e.keyCode == 13)$('#btnLogin').click();
})
$('#nombre').html(nombreEmpresa);
$('#btnLogin').click(function(){
	if($('form')[0].checkValidity()){
		$('#pass').val(SHA1($('#fakePass').val()))
		$('#loginUsuario')
			.find('#fakePass')
				.val("")
			.end()
			.submit();			
	}else{
		btnLoad.status = false;
	}
})
$("#solicitaragenda").submit(function( e ) {
	e.preventDefault();
	var formulario = $("#solicitaragenda").not('#fakePass').serialize();
	$.ajax({
		type: "POST",
		data: formulario,
		url: "php/crearagenda.php",
		dataType: "json",
	}).done(function(mns){
		if(mns.success){
			window.location =  $("#empresa").val()+"/";
		}else{
			alert(mns.error);
		}
	}).fail(function(mns){
		alert("Error en la conexión");
	});
})
$('#ancho').val(screen.width);
$('#alto').val(screen.height);

if ($_GET("err"))error($_GET("err"));

function error(mns){
	$('#loginUsuarioPopoverTxt').html(mns)
	$('#loginUsuario')
		.popover('show')
		.find('input')
			.each(function(){
				$(this).addClass('input-error');
			})
}
function getUserInfo() {
	FB.api('/me', function(response) {
		window.location ="face/validar.php?nombre="+response.name+"&email="+ response.email+"&id="+response.id;
	});
}
function Logout(){
	FB.logout(function(){document.location.reload();});
}
function cambiarPass(){
	$('#pass').val(SHA1($('#fakePass').val()))
	$('#pass2').val(SHA1($('#fakePass2').val()))
	$('#frmCambiarPass').submit();
}
/*
function loginFace(){
	FB.login(function(response) {
	   if (response.authResponse) {
			getUserInfo();
		} else {
			console.log('User cancelled login or did not fully authorize.');
		}
	 },{scope: 'email'});
}
/*
(function(d){
	
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
   
 }(document));
window.fbAsyncInit = function() {
	
    FB.init({
    appId      : '624860847641117', // App ID
      channelUrl : 'https://www.lebouquet.es', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });


	FB.Event.subscribe('auth.authResponseChange', function(response) {
		 if (response.status === 'connected') {
			//SUCCESS
		}else if (response.status === 'not_authorized')   {
			//FAILED
		}else{
			//UNKNOWN ERROR
		}
	});
};
*/