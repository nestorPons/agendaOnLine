
'use strict'
self.addEventListener('message',(e)=>{
    let data = new FormData()
    data.append( "json", JSON.stringify( {controller : 'refresh'} ) );
    fetch('/app.php', {
        method: 'post',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({controller:'refresh'})
    })
    .then(r => console.log(r))
    .catch( error => {
        console.log('Hubo un problema con la petición Fetch:');
        console.error(error.message); 
      });
})