'use strict'

function createDB() {
  console.log('createDB!!!')

  idb.open('products', 1, function(upgradeDB) {
  var store = upgradeDB.createObjectStore('beverages', {
    keyPath: 'id'
  });
  });
 
// objectStore.get devuelve un request, como todas las APIs
// de IndexedDB, pero si no controlamos los errores 
// individualmente, podemos simplificar un poco el código
 

}

const applicationServerPublicKey = 'BLCEIVNzSyObTkpaOQkwuuEYZaYE-zDb9oZiCfunWxcPClrQj2d9NFH78C-V_njjS9hwZY1gLUzCP5qEmIQgBiI';

if ('serviceWorker' in navigator && ('indexedDB' in window)) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js', {scope: '/'})
    .then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    })
    .catch(function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}
