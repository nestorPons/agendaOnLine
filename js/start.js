
loadSync('../../js/jquery.min.js' , function(){
	loadAsync('../../js/jquery-ui.min.js',function(){
		loadAsync('../../js/metro.js',function(){
			loadSync('../../js/jquery.mask.min.js',function(){
				loadAsync('../../js/funciones.js',function(){
					loadAsync(url(),function(){
						if (window.innerWidth < 800) loadAsync('../../js/jquery.mobile.custom.min.js' )
					})
				})
			})
		})
	})
})

function url(){
	var pathArray = window.location.pathname.split( '/' );

	if(pathArray.indexOf("users")!=-1){
		return '../../js/users.js';
	}else if (pathArray.indexOf("admin")!=-1){
		return '../../js/admin.js';
		//getAjax('../../../../php/admin/consulta.php');
	}else if(pathArray.indexOf("nuevo.php")!=-1){
		return '../../js/nuevo.js';
	}else if(pathArray.indexOf("formulario.html")!=-1){
		return 'js/formulario.js';
	}else{
		return  '../../js/index.js';
	}
}

function loadAsync(src, callback){
    var script = document.createElement('script');
    script.src = src;

    if(callback !== null){
        if (script.readyState) { // IE, incl. IE9
            script.onreadystatechange = function() {
                if (script.readyState == "loaded" || script.readyState == "complete") {
                    script.onreadystatechange = null;
                   typeof callback == "function" && callback();
                }
            };
        } else {
            script.onload = function() { // Other browsers
                typeof callback == "function" && callback();
            };
        }
    }
    document.getElementsByTagName('head')[0].appendChild(script);
}

function loadSync(nombre, callback) {
    var s = document.createElement("script");
    s.onload = callback;
    s.src = nombre;
    document.querySelector("head").appendChild(s);
}

function getAjax(ajax_url){
	  // Debería trabajar en hacer esto un poco más limpio, de momento vale para hacer funcionar el ejemplo
	  var params = '';

	  //Añadimos los parámetros a la URL
	 // ajax_url += '?' + params;

	  // Creamos un nuevo objeto encargado de la comunicación
	  var ajax_request = new XMLHttpRequest();

	  // Definimos una función a ejecutar cuándo la solicitud Ajax tiene alguna información
	  ajax_request.onreadystatechange = function() {

		  // see readyState es 4, proseguir
			if (ajax_request.readyState == 4 ) {

				// Analizaos el responseText que contendrá el JSON enviado desde el servidor
				var datos = JSON.parse( ajax_request.responseText );

				/*festivos = datos.festivos;
				horarios = datos.horarios;
				agenda = datos.agenda;*/

			}
	   }

	   // Definimos como queremos realizar la comunicación
	   ajax_request.open( "GET", ajax_url );

	   //Enviamos la solictud con los parámetros que habíamos definido
	   ajax_request.send();

   };
