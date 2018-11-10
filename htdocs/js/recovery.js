
var recovery = {
    init : function(){
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

                        $('body')
                            .removeClass()  
                            .html(r)

                },'html');
            } else {
                btn.load.hide();
                alert('Contraseñas incorrectas');
            }
        })
    }
}