<?php 
  $empresa = $_GET['nombre_empresa']; 
  $norm_empresa = normalize( $empresa); 
  $url_icons = "empresas/$norm_empresa";
?>
{
  "version": "1",
  "short_name": "<?= $empresa?>",
  "name": "<?= $empresa?> agenda onLine",
  "description": "Agenda para reserva de citas por internet en tu centro  <?= $empresa?>.",
  "display": "standalone", 
  "start_url": "app.php/?empresa=<?=$norm_empresa?>",
  "background_color": "#fff",
  "theme_color": "#<?= $_GET['color_main']?>", 
  "orientation": "portrait",
  "icons": [
      {
        "src": "<?=$url_icons?>/logo_16.png",
        "type": "image/png",
        "sizes": "16x16"
      }, {
        "src": "<?=$url_icons?>/logo_24.png",
        "type": "image/png",
        "sizes": "24x24"
      }, {
        "src": "<?=$url_icons?>/logo_32.png",
        "type": "image/png",
        "sizes": "32x32"
      }, {      
        "src": "<?=$url_icons?>/logo_48.png",
        "type": "image/png",
        "sizes": "48X48"
      }, {
        "src": "<?=$url_icons?>/logo_64.png",
        "type": "image/png",
        "sizes": "64x64"
      }, {
        "src": "<?=$url_icons?>/logo_128.png",
        "type": "image/png",
        "sizes": "128X128"
      } , {
        "src": "<?=$url_icons?>/logo_144.png",
        "type": "image/png",
        "sizes": "144x144"
      } , {
        "src": "<?=$url_icons?>/logo_256.png",
        "type": "image/png",
        "sizes": "256x256"
      }
    ],
  "developer": {
    "name": "Néstor Pons",
    "url": "https://nestorpons.github.io/reservaTucita/"
  },
  "permissions": {
    "desktop-notification": {
      "description": "Needed for creating system notifications."
    }
  }
}
<?php
    function normalize($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
        ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
        bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = str_replace(' ', '', trim($cadena));
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
     }
?>