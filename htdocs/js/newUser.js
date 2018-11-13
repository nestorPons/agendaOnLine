$('#frmNewUser').submit(function(e){

    e.preventDefault();
    let	data = {
        nombre : $('#nom_new_user').val(), 
        email : $('#email_new_user').val(),
        tel : $('#tel_new_user').val(),  
        pass : Tools.SHA($('#pass_new_user').val()), 
        controller : 'login', 
        action : SAVE
    },		
        _validate =  function (pass1, pass2) {
            if (!$.isEmpty(pass1) && pass1 === pass2){
                if (pass1.length < 6 ) {
                    notify.error('El password debe de ser de 6 caracteres mínimo','Password invalido') 
                    return false;
                } else {
                    return true;
                }
            } else {
                notify.error('Los passwords no coinciden!','Password invalido') 
                return false;
            }
        }

    if (_validate($('#pass_new_user').val(), $('#rpass_new_user').val())){

        $.post(URL, data,function (r) {
            if (r.success) {
                notify.success('Le hemos enviado un email de validación', 'Registro aceptado')
                $('#newUser').hide()
                $('#secNewNotification').removeClass()
            } else {
                notify.error(r.err, 'Error: '+ r.code)
                echo(r);
                }	
            btn.load.hide()
        },'json');	

    } else {
        btn.load.hide()
    }
})