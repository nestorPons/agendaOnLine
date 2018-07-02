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

	if(pathArray.indexOf("users")!=-1){
		return '/js/users.js';
	}else if (pathArray.indexOf("admin")!=-1){
		return '/js/admin.js';
	}else if(pathArray.indexOf("nuevo.php")!=-1){
		return '/js/nuevo.js';
	}else if(pathArray.indexOf("formulario.html")!=-1){
		return '/js/formulario.js';
	}else if(pathArray.indexOf("create.html")!=-1){
		return '/js/create.js';
	}else{
		return  '/js/login.js';
	}
}
loadSync('/js/jquery.min.js' , function(){
	if (window.innerWidth < 800) {loadAsync('/js/jquery.mobile.min.js' )}
	//Para cargar jquery en electron
	if (typeof module!='undefined') {$ = jQuery = module.exports}
	loadAsync('/js/jquery-ui.min.js',function(){
		loadAsync('/js/metro.js',function(){
			loadSync('/js/jquery.mask.min.js',function(){
				loadSync('/js/funciones.js',function(){
					loadSync(url(),function(){
					})
				})
			})
		})
	})
})