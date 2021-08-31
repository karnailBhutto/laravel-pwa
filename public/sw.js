var CACHE_STATIC_NAME = 'static-v1';
var CACHE_DYNAMIC_NAME = 'dynamic-v1';

importScripts('/localforage/dist/localforage.js');
importScripts('/js/indexeddb/data-sync.js');
//importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.1.5/workbox-sw.js');
 
var urlsToCache = [
	'/manifest.json',
	'/offline',
	'/sw.js',
	'/localforage/dist/localforage.js',
	'https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js',
	'js/qrCodeScanner.js',
	'/images/logo.png',
	'/login',
	'/search',
	'/dashboard',
	'/outlets?id=1',
	'/addnew?id=1',
	'/orders?id=1',
	'/js/indexeddb/register_outletDB.js',
	'/js/indexeddb/order_historyDB.js',
	'/js/indexeddb/order_cartDB.js',
	'/images/icon/shopping_cart.png',
	'/images/fempro.png',
	'/images/inco.png',
	'/images/baby.png',
	'/images/product_sku/drypers/skinature-xl_big.png',
	'/images/product_sku/drypers/thumbnail_133100108000.jpg',
	'/images/product_sku/drypers/thumbnail_133100195001.jpg',
	'/images/product_sku/drypers/thumbnail_baby_care.jpg',
	'/images/product_sku/drypers/dcp-2.jpg',
	'/images/product_sku/drypers/thumbnail_133100442000.jpg',
	'/images/product_sku/libresse/libresse.png',
	'/images/product_sku/libresse/thumbnail_1714000009.jpg',
	'/images/product_sku/libresse/v-routine.jpg',
	'/images/product_sku/tena/tena.jpg',
	'/myorder/ajax/1',
	'/myorder/ajax/2',
	'/myorder/ajax/3',
	'/myorder/ajax/4',
	'/myorder/pack/1',
	'/myorder/pack/2',
	'/myorder/pack/3',
	'/myorder/pack/4',
	'/myorder/pack/5',
	'/myorder/pack/6',
	'/myorder/pack/7',
	'/myorder/pack/8',
	'/myorder/pack/9',
	'/myorder/pack/10',
	'/myorder/pack/11',
	'/myorder/pack/12',
	'/myorder/pack/13',
	'/myform/ajax/00',
	'/myform/ajax/01',
	'/myform/ajax/02',
	'/myform/ajax/03',
	'/myform/town/010',
	'/myform/town/011',
	'/myform/town/012',
	'/myform/town/013',
	'/myform/town/014',
	'/myform/town/015',
	'/myform/town/016',
	'/myform/town/017',
	'/myform/town/018',
	'/myform/town/019',
	'/myform/town/020',
	'/myform/town/021',
	'/myform/town/022',
	'/myform/town/023',
	'/myform/town/024',
	'/myform/town/025',
	'/myform/town/026',
	'/myform/town/027',
	'/myform/town/028',
	'/myform/town/029',
	'/myform/town/030',
	'/myform/town/031',
	'/myform/town/032',
	'/myorder/prod1/1?order=0',
	'/myorder/prod1/2?order=0',
	'/myorder/prod1/3?order=0',
	'/myorder/prod1/4?order=0',
	'/myorder/prod1/5?order=0',
	'/myorder/prod1/6?order=0',
	'/myorder/prod1/7?order=0',
	'/myorder/prod1/8?order=0',
	'/myorder/prod1/9?order=0',
	'/myorder/prod1/10?order=0',
	'/myorder/prod1/11?order=0',
	'/myorder/prod1/12?order=0',
	'/myorder/prod1/13?order=0',
	'/myorder/prod1/14?order=0',
	'/myorder/prod1/15?order=0',
	'/myorder/prod1/16?order=0',
	'/myorder/prod1/17?order=0',
	'/myorder/prod1/18?order=0',
	'/myorder/prod1/19?order=0',
	'/myorder/prod1/20?order=0',
	'/myorder/prod1/21?order=0',
	'/myorder/prod1/22?order=0',
	'/myorder/prod1/23?order=0',
	'/myorder/prod1/24?order=0',
	'/myorder/prod1/25?order=0',
	'/myorder/prod1/26?order=0',
	'/myorder/prod1/27?order=0',
	'/myorder/prod1/28?order=0',
	'/myorder/prod1/29?order=0',
	'/myorder/prod1/30?order=0',
	'/myorder/prod1/31?order=0',
	'/myorder/prod1/32?order=0',
	'/myorder/prod1/33?order=0',
	'/myorder/prod1/34?order=0',
	'/myorder/prod1/35?order=0',
	'/myorder/prod1/36?order=0',
	'/myorder/prod1/37?order=0',
	'/myorder/prod1/38?order=0',
	'/myorder/prod1/39?order=0',
	'/myorder/prod1/40?order=0',
	'/myorder/prod1/41?order=0',
	'/myorder/prod1/42?order=0',
	'/myorder/prod1/43?order=0',
	'/myorder/prod1/44?order=0',
	'/myorder/prod1/45?order=0',
	'/myorder/prod1/46?order=0',
	'/myorder/prod1/47?order=0',
	'/myorder/prod1/48?order=0',
	'/myorder/prod1/49?order=0',
	'/myorder/prod1/50?order=0',
	'/myorder/prod1/51?order=0',
	'/myorder/prod1/52?order=0',
	'/myorder/prod1/53?order=0',
	'/myorder/prod1/54?order=0',
	'/myorder/prod1/55?order=0',
	'/myorder/prod1/56?order=0',
	'/myorder/prod1/57?order=0',
	'/myorder/prod1/58?order=0',
	'/myorder/prod1/59?order=0',
	'/myorder/prod1/60?order=0',
	'/myorder/prod1/61?order=0',
	'/myorder/prod1/62?order=0',
	'/myorder/prod1/63?order=0',
	'/myorder/prod1/64?order=0',
	'/myorder/prod1/65?order=0',
	'/myorder/prod1/66?order=0',
	'/myorder/prod1/67?order=0',
	'/myorder/prod1/68?order=0',
	'/myorder/prod1/69?order=0',
	'/myorder/prod1/70?order=0',
	'/myorder/prod1/71?order=0',
	'/myorder/prod1/72?order=0',
	'/myorder/prod1/73?order=0',
	'/myorder/prod1/74?order=0',
	'/myorder/prod1/75?order=0',
	'/myorder/prod1/76?order=0',
	'/myorder/prod1/77?order=0',
	'/myorder/prod1/78?order=0',
	'/myorder/prod1/79?order=0',
	'/myorder/prod1/80?order=0',
	'/myorder/prod1/81?order=0',
	'/myorder/prod1/82?order=0',
	'/myorder/prod1/83?order=0',
	'/myorder/prod1/84?order=0',
	'/myorder/prod1/85?order=0',
	'/myorder/prod1/86?order=0',
	'/myorder/prod1/87?order=0',
	'/myorder/prod1/88?order=0',
	'/myorder/prod1/89?order=0',
	'/myorder/prod1/90?order=0',
	'/myorder/prod1/98?order=0',
	'/myorder/prod1/99?order=0',
	'/myorder/prod1/100?order=0',
	'/myorder/prod1/101?order=0',
	'/myorder/prod1/102?order=0',
	'/myorder/prod1/103?order=0',
	'/myorder/prod1/104?order=0',
	'/myorder/prod1/105?order=0',
	'/myorder/prod1/106?order=0',
	'/myorder/prod1/107?order=0',
	'/myorder/prod1/108?order=0',
	'/myorder/prod1/109?order=0',
	'/myorder/prod1/110?order=0',
	'/myorder/prod1/111?order=0',
	'/myorder/prod1/112?order=0',
	'/myorder/prod1/113?order=0',
	'/myorder/prod1/114?order=0',
	'/myorder/prod1/115?order=0',
	'/myorder/prod1/116?order=0',
	'/myorder/prod1/117?order=0',
	'/myorder/prod1/118?order=0',
	'/myorder/prod1/119?order=0',
	'/myorder/prod1/120?order=0',
	'/myorder/prod1/121?order=0',
	'/myorder/prod1/122?order=0',
	'/myorder/prod1/123?order=0',
	'/myorder/prod1/124?order=0',
	'/myorder/prod1/125?order=0',
	'/myorder/prod1/126?order=0',
	'/myorder/prod1/127?order=0',
	'/myorder/prod1/128?order=0',
	'/myorder/prod1/129?order=0',
	'/myorder/prod1/130?order=0',
	'/myorder/prod1/131?order=0',
	'/myorder/prod1/132?order=0',
	'/myorder/prod1/133?order=0',
	'/myorder/prod1/134?order=0',
	'/myorder/prod1/135?order=0',
	'/myorder/prod1/136?order=0',
	'/myorder/prod1/137?order=0',
	'/myorder/prod1/138?order=0',
	'/myorder/prod1/139?order=0',
	'/myorder/prod1/140?order=0',
	'/myorder/prod1/141?order=0',
	'/myorder/prod1/142?order=0',
	'/myorder/prod1/143?order=0',
	'/myorder/prod1/144?order=0',
	'/myorder/prod1/145?order=0',
	'/myorder/prod1/146?order=0',
	'/myorder/prod1/147?order=0',
	'/myorder/prod1/148?order=0',
	'/myorder/prod1/149?order=0',
	'/myorder/prod1/150?order=0',
	'/myorder/prod1/151?order=0',
	'/myorder/prod1/152?order=0',
	'/myorder/prod1/153?order=0',
	'/myorder/prod1/154?order=0',
	'/myorder/prod1/155?order=0',
	'/myorder/prod1/156?order=0',
	'/myorder/prod1/157?order=0',
	'/myorder/prod1/158?order=0',
	'/myorder/prod1/159?order=0',
	'/myorder/prod1/160?order=0',
	'/myorder/prod1/161?order=0',
	'/myorder/prod1/162?order=0',
	'/myorder/prod1/163?order=0',
	'/myorder/prod1/164?order=0',
	'/myorder/prod1/165?order=0',
	'/myorder/prod1/166?order=0',
	'/myorder/prod1/167?order=0',
	'/myorder/prod1/168?order=0',
	'/myorder/prod1/169?order=0',
	'/myorder/prod1/170?order=0',
	'/myorder/prod1/171?order=0',
	'/myorder/prod1/172?order=0',
	'/myorder/prod1/173?order=0',
	'/myorder/prod1/174?order=0',
	'/myorder/prod1/175?order=0',
	'/myorder/prod1/176?order=0',
	'/myorder/prod1/177?order=0',
	'/myorder/prod1/178?order=0',
	'/myorder/prod1/179?order=0',
	'/myorder/prod1/180?order=0',
	'/myorder/prod1/181?order=0',
	'/myorder/prod1/182?order=0',
	'/myorder/prod1/183?order=0',
	'/myorder/prod1/184?order=0',
	'/myorder/prod1/185?order=0',
	'/myorder/prod1/186?order=0',
	'/myorder/prod1/187?order=0',
	'/myorder/prod1/188?order=0',
	'/myorder/prod1/189?order=0',
	'/myorder/prod1/190?order=0',
	'/myorder/prod1/191?order=0',
	'/myorder/prod1/192?order=0',
	'/myorder/prod1/193?order=0',
	'/myorder/prod1/194?order=0',
	'/myorder/prod1/195?order=0',
	'/myorder/prod1/196?order=0',
	'/myorder/prod1/197?order=0',
	'/myorder/prod1/198?order=0',
	'/myorder/prod1/199?order=0',
	'/myorder/prod1/200?order=0',
	'/myorder/prod1/234?order=0'
];

//var urlsToCache = secondArray; //console.log(urlsToCache);

self.addEventListener('install', function (event) {
  console.log('Installing Service Worker ...', event);
  event.waitUntil(
    caches.open(CACHE_STATIC_NAME)
      .then(function (cache) {
        console.log('Precaching App Shell');
		cache.addAll(urlsToCache);
      })
  )
});

self.addEventListener('activate', function (event) {
  console.log('Activating Service Worker ....', event);
  event.waitUntil(
    caches.keys()
      .then(function (keyList) {
        return Promise.all(keyList.map(function (key) {
          if (key !== CACHE_STATIC_NAME && key !== CACHE_DYNAMIC_NAME) {
            console.log('Removing old cache.', key);
            return caches.delete(key);
          }
        }));
      })
  );
  return self.clients.claim();
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    // /*Try the network*/
    fetch(event.request) 
      .then(function(res) {  //console.log(res);
        return caches.open(CACHE_DYNAMIC_NAME)
          .then(function(cache) {
            // /*Put in cache if succeeds*/
			//console.log(res);
            cache.put(event.request.url, res.clone());
            return res;
          })
      }) 
      .catch(function(err) {
          // /*Fallback to cache*/
          //return caches.match(event.request)
		   return caches.match(event.request, {ignoreSearch: true})
		  .then(function(res){
			if (res === undefined) { 
			  // /*get and return the offline page*/
			  return caches.match('offline');
			  //tempAlert("No internet connection!",3000);
			} 
			return res;
		})
      })
  );
});

self.addEventListener('sync', event => {
  //console.log('[SW] Syncing', event);
  event.waitUntil(syncSW(event)); // (1)
});

function syncSW(event) {
  // This example handles a sync task
  if (event.tag === 'sync-outlet') {
    const outlets = [];

    // Looping through all tasks in the pwa-offline-tasks database (2)
    register.iterate(function (value, key, iterationNumber) {
	  //console.log([key, value]); console.log((key, value.outletid));
      outlets.push(value); // (3)
    }).then(function (data) { 
      Promise.all(outlets) // (5) 
        .then(function (data) {
            for (var outlets of data)
            {
                kirimData(outlets);
            }
			console.log('[SW] Offline outlet sync succeeded.');
        }).catch(function (err) {
          console.error('[SW] Offline outlet sync failed:', err);
        });
    }).catch(function (err) {
      console.error('[SW] Iterate through offline outline failed:', err);
    });
  }
  
  if (event.tag === 'sync-order') {
    const orders = [];

    ////Looping through all tasks in the pwa-offline-tasks database (2)
    order.iterate(function (value, key, iterationNumber) {
	 //// console.log([key, value]); console.log((key, value.outletid));
      orders.push(value); // (3)
    }).then(function (data) { 
      Promise.all(orders) // (5) 
        .then(function (data) {
            for (var orders of data)
            {
                insertData(orders);
            }
			console.log('[SW] Offline order sync succeeded.');
        }).catch(function (err) {
          console.error('[SW] Offline order sync failed:', err);
        });
    }).catch(function (err) {
      console.error('[SW] Iterate through offline order failed:', err);
    });
  }
  
  if (event.tag === 'sync-detail') {
    const orderdetails = [];

    orderdetail.iterate(function (value, key, iterationNumber) {
	  //console.log([key, value]); console.log((key, value.outletid));
      orderdetails.push(value); // (3)
    }).then(function (data) { 
      Promise.all(orderdetails) // (5) 
        .then(function (data) {
            for (var orderdetails of data)
            {
                masukData(orderdetails);
            }
			console.log('[SW] Offline orderdetails sync succeeded.');
        }).catch(function (err) {
          console.error('[SW] Offline orderdetails sync failed:', err);
        });
    }).catch(function (err) {
      console.error('[SW] Iterate through offline orderdetails failed:', err);
    });
  }
  
};




