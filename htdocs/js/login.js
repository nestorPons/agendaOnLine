
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
	if ($_GET_FRIEND_URL("err"))error($_GET_FRIEND_URL("err"));

	$('#loginUsuario').keyup(function(e){
		if(e.keyCode == 13)$('#btnLogin').click();
	})

	$('form').submit(function(e){
		var pass = $(this).find('#fakePass').val()
		$(this).find('#pass').val(SHA(pass))
	})

})