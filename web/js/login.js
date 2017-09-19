
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
	$('#alto').val(screen.height);

	if ($_GET("err"))error($_GET("err"));

	$('#loginUsuario').keyup(function(e){
		if(e.keyCode == 13)$('#btnLogin').click();
	})

})