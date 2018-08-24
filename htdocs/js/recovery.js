
$('#frmNewPass').on('submit',function(e){
    e.preventDefault(); 
    let pass = document.getElementById('pass').value.trim(), 
        rpass = document.getElementById('rpass').value.trim(),
        token =  document.getElementById('token').value,
        idUser = document.getElementById('idUser').value, 
        $body = document.getElementsByTagName('body');

    if(pass == rpass){
        let data = {
            controller : 'validar', 
            action : 'newpass' , 
            token : token,
            idUser : idUser, 
            pass :  Tools.SHA(pass)
        }
        $.post('index',data,r=>{
            if(r.success){
                $('body')
                    .removeClass()  
                    .html(r)
                notify.success('Contraseña cambiada con éxito', 'Cambio contraseña');
            } else {
                let res = JSON.parse(r); 
                res.err = res.err.split("<br>")
                notify.error(res.err[1], res.err[0],3000);
            }
         },'html');
    } else {
        alert('Contraseñas incorrectas');
    }
})