var CACHE_NAME = 'sfa_kh';
for(var i = 0; i < 1001; i++) { var order = '/orders?id='+i+','; 
var urlsToCache = [
  '/',
  '/login',
  '/manifest.json',
  '/sw.js',
  '/dashboard',
  '/outlets',
  '/plugins/fontawesome-free/css/all.min.css',
  '/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
  '/dist/css/adminlte.min.css',
  '/images/logo.png',
  '/images/icon/empty-list.png',
  '/plugins/fontawesome-free/webfonts/fa-solid-900.woff',
  '/plugins/fontawesome-free/webfonts/fa-solid-900.woff2',
  '/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
  '/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
  '/static/icon/apple-icon-144x144.png',
  '/favicon.ico',
  '/plugins/fontawesome-free/webfonts/fa-regular-400.woff',
  '/plugins/fontawesome-free/webfonts/fa-regular-400.woff2',
  '/orders/1',
  '/plugins/select2/css/select2.min.css',
  '/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
  '/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css',
  '/master',
  '/images/baby.png',
  '/images/fempro.png',
  '/images/inco.png',
  '/images/tissue.png',
  '/images/icon/shopping_cart.png',
  '/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
  '/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
  '/js/qrCodeScanner.js',
  '/dist/js/demo.js',
  '/plugins/jquery/jquery.min.js',
  '/plugins/bootstrap/js/bootstrap.bundle.min.js',
  '/dist/js/adminlte.js',
  '/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
  'plugins/select2/js/select2.full.min.js',
  'plugins/datatables/jquery.dataTables.min.js',
  '/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
  'plugins/datatables-responsive/js/dataTables.responsive.min.js',
  '/plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
  '/plugins/datatables-buttons/js/dataTables.buttons.min.js',
  '/plugins/datatables-buttons/js/buttons.bootstrap4.min.js',
  '/plugins/pdfmake/vfs_fonts.js ',
  '/plugins/datatables-buttons/js/buttons.html5.min.js',
  '/plugins/datatables-buttons/js/buttons.print.min.js',
  '/plugins/datatables-buttons/js/buttons.colVis.min.js',
  //console.log(order),
  '/history'
];

}  


self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
}); 

/* Serve cached content when offline */
self.addEventListener('fetch', function(e) {
  e.respondWith(
    caches.match(e.request).then(function(response) {
      return response || fetch(e.request);
    })
  );
});    

// self.addEventListener('fetch', function(event) {
  // event.respondWith(
    // caches.match(event.request)
      // .then(function(response) {
     //// Cache hit - return response
        // if (response) {
          // return response;
        // }
        // return fetch(event.request);
      // }
    // )
  // );
// });

// self.addEventListener('fetch', evt => {
 // index.html redirects to "/".  Therefore use  cache.put() to offline the
  //the opaque redirect.
  // fetch('index.php', { redirect: 'manual' }).then(resp => {
    // return caches.open('db').then(cache => {
      // return cache.put(evt.request, resp);
    // });
  // });
// });

self.addEventListener('activate', function(event) {
  var cacheWhitelist = ['sfa_kh'];
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// self.addEventListener('activate', function(e) {
  // self.registration.unregister()
    // .then(function() {
      // return self.clients.matchAll();
    // })
    // .then(function(clients) {
      // clients.forEach(client => client.navigate(client.url))
    // });
// });