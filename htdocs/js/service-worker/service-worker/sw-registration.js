//'use strict'

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
