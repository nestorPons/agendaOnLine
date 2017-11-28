
var error = function (mns){
	$('#loginUsuarioPopoverTxt').html(mns)
	$('#loginUsuario')
		.popover('show')
		.find('input')
			.each(function(){
				$(this).addClass('input-error');
			})
}

$(function(){
	$('#ancho').val(screen.width);
	if ($_GET("err"))error($_GET("err"));

	$('#loginUsuario').keyup(function(e){
		if(e.keyCode == 13)$('#btnLogin').click();
	})

	$('form').submit(function(e){
		var pass = $(this).find('#fakePass').val()
		echo (pass)
		$(this).find('#pass').val(SHA(pass))
	})

})