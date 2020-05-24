// Se usa mara mandar notificaciones push como recordatorios de las citas
const version  = 'v2.5'; 

self.addEventListener('fetch', event => {
  if(event.request.method === "POST"){
      //Primero extrae el post para saber a donde va
      var data = {};

        event.request.formData().then(formData => {

          for(var pair of formData.entries()) {
            var key = pair[0];
            var value =  pair[1];
            data[key] = value;
          }
            return(data)
      })
      .then( data   => {

        // Peticion para self
        if(data.controller=="service-worker"){
          switch(data.action){
            case 'refresh': 
              timer.stopInterval()
              timer.start()
            break; 
            case 'start' : 
              timer.start()
            break; 
            case 'stop' : 
              timer.stopInterval()
            break; 
          }        
        }
      });
    }
});

var
swdb = {
  read : (callback) => {
    console.log('Pidiendo datos .... ')
    var request = indexedDB.open('citas')
    request.onsuccess = function(e) {
      let db = e.target.result, 
          data = db
            .transaction('cita','readonly')
            .objectStore('cita')
            .getAll();
          
      data.onsuccess = d => callback(data.result)
      data.onerror = () => callback(false)
      data.oncomplete = e => db.close()
    }
    
  }, 
  update : (id, field, value, callback) =>{
    console.log('Editando datos .... ')
    var request = indexedDB.open('citas')
    request.onsuccess = function(e) {
      var db = e.target.result
      var store = db.transaction('cita','readwrite').objectStore('cita'), 
          request = store.get(id)

      request.onsuccess = e => {
        var data = request.result;
        data.notificacion = 1 

        store.put(data).onsuccess = e =>{ 
          typeof callback == "function" && callback()
         }
      }
      request.onerror = e => {
        console.warn("error editando...")
        callback(false);
      }
      request.oncomplete = e => db.close()
    }
  }

}, 
timer = { 
  interval : null, 
  timerSetInterval : function(data){

    const now = new Date()

    //Avisar una hora antes
    now.setHours(now.getHours()+1)

    data.forEach(function(d) {

      const new_date = new Date(d.fecha + ' ' + d.hora)

      if(now >= new_date && d.notificacion === 0){ 
          //Muestra notificacion 
          self.registration.showNotification('Recordatorio de su cita',         
              {
                body: 'Tiene una cita en su centro,\na las: ' + d.hora.substr(0,5)  +' h.',
                icon: '/img/notification.png', 
                badge: 'img/android-chrome-192x192.png', 
              }
            )
          swdb.update(d.id, 'notificacion' , 1, timer.start )                  
          // Cambia el estado del campo notificacion 

      }
    }, this);
  
  }, 
  stopInterval : ( ) => {
    clearInterval(this.timerSetInterval)
  },
  start : function(){
    console.log('Iniciando el timer ...')
    //Extraemos los datos 
    clearInterval(timer.interval)
    swdb.read ( (data=null) => {
      if(data){
        timer.timerSetInterval(data)
        timer.interval = setInterval(()=>timer.timerSetInterval(data), 1000 * 60)
      }
    })
  }
}