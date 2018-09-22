//Comprobamos si ya ha sido cargado
if(typeof $!='function') {
	var loadSync = function ( name , callback) {
		var s = document.createElement("script");
		s.onload = callback;
		s.src = name;
		document.querySelector("head").appendChild(s);
	 }
	var loadAsync = function (src, callback){
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
	var url = function (){
		var pathArray = window.location.pathname.split( '/' );

		if(pathArray.indexOf("nuevo.php")!=-1){
			return '/js/nuevo.js';
		}else if(pathArray.indexOf("formulario.html")!=-1){
			return '/js/formulario.js';
		}else if(pathArray.indexOf("create.html")!=-1){
			return '/js/create.js';
		}else{
			return  '/js/login.js';
		}
	 }
	loadSync('/js/lib/idb.js' , function(){
		loadSync('/js/service-worker/sw-registration.js')
	 })
	loadSync('/js/lib/jquery.min.js' , function(){
		if (window.innerWidth < 800) {loadAsync('/js/lib/jquery.mobile.min.js' )}
		//Para cargar jquery en electron
		if (typeof module!='undefined') {$ = jQuery = module.exports}
		loadAsync('/js/lib/jquery-ui.min.js',function(){
			
			loadAsync('/js/lib/metro.js',function(){
				loadSync('/js/lib/jquery.mask.min.js')
				loadSync('/js/funciones.js',function(){

						loadAsync(url(),function(){
				
						})
				})
			})
		})
	 })
}