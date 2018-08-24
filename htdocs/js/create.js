var password = document.getElementById("password"),
            confirm_password = document.getElementById("rpassword")

function validatePassword(){
    if(password.value != confirm_password.value) 
    confirm_password.setCustomValidity("Contraseñas no coinciden")
    else
    confirm_password.setCustomValidity('')
    
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

$('form').submit(function(e){

    var pass = $(this).find('#password').val()
    $(this).find('#password').val('')
    $(this).find('#rpassword').val('')
    $(this).find('#pass').val(Tools.SHA(pass))

})
