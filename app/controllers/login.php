<?php
use MatthiasMullie\Minify;

if (isset($_POST['action'])){ 
    require_once URL_AJAX . 'login/' . $_POST['action'] . '.php' ;
    
    header('Content-Type: application/json');
    echo json_encode($r);

}else if (isset($_POST['view'])){
    require_once URL_VIEWS . 'login/' . $_POST['view'] . '.php';
} else {
    if(isset($_COOKIE["auth"])){
    
        $Login = new \models\Login;
        if ($action = $Login->authToken($_COOKIE["auth"])){
            require_once URL_VIEWS . '/login/pinpass.php';
        }else{ 
            $Login->logout();
        }      
        
    } else {
        $url_font_main = "https://fonts.googleapis.com/css?family=" .
        str_replace(' ' ,'+' ,CONFIG['font_main']) ."|" . 
        str_replace(' ' ,'+' ,CONFIG['font_tile']) ; 
    
        // Comprimir y agrupar js y css
        $path = URL_LIB;
        require_once $path . 'minify/src/Minify.php';
        require_once $path . 'minify/src/CSS.php';
        require_once $path . 'minify/src/JS.php';
        require_once $path . 'minify/src/Exception.php';
        require_once $path . 'minify/src/Exceptions/BasicException.php';
        require_once $path . 'minify/src/Exceptions/FileImportException.php';
        require_once $path . 'minify/src/Exceptions/IOException.php';
        require_once $path . 'path-converter/src/ConverterInterface.php';
        require_once $path . 'path-converter/src/Converter.php';
        
        
        
        $minifier = new Minify\JS( 
            URL_JS . 'lib/idb.js',
            URL_JS . 'service-worker/sw-registration.js'
        );
        $minifier->minify( URL_JS . 'service-worker/registration.min.js');
        
        $minifier = new Minify\JS( 
            URL_JS . 'lib/jquery.min.js',
            URL_JS . 'lib/jquery-ui.min.js', 
            URL_JS . 'lib/jquery.mobile.min.js',
            URL_JS . 'lib/metro.js',
            URL_JS . 'lib/jquery.mask.min.js',
            URL_JS . 'funciones.js', 
            URL_JS . 'login.js'
        );
        $minifier->minify(URL_JS . 'index.min.js');
        
        $minifier = new Minify\CSS( 
            URL_CSS . 'jquery-ui.min.css',
            URL_CSS . 'metro.css', 
            URL_CSS . 'iconos.css',
            URL_CSS . 'font.css',
            URL_CSS . 'main.css',
            URL_CSS . 'login.css',
            "empresas/{$Empresa->code()}/style.css"
        );
        $minifier->minify(URL_CSS . 'index.min.css'); 
        /**/
        require_once URL_VIEWS . 'login.php';
        
    }
}