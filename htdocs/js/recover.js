var recover = {
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
 }
$('#recover').on('submit','form',function(e){
    e.preventDefault()
    recover.send(
        ()=>main.toggle($('#newPass'),'back')
    )
            
})