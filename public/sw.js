importScripts('https://storage.googleapis.com/workbox-cdn/releases/3.6.1/workbox-sw.js');

const JS_CACHE = 'js-cache-v03';
const CSS_CACHE = 'css-cache-v02';
const IMAGE_CACHE = 'image-cache-v01';


workbox.routing.registerRoute(
  // Cache CSS files
  /.*\.js/,
  // Use cache but update in the background ASAP
  workbox.strategies.staleWhileRevalidate({
    // Use a custom cache name
    cacheName: JS_CACHE,
  })
);

workbox.routing.registerRoute(
  // Cache CSS files
  /.*\.css/,
  // Use cache but update in the background ASAP
  workbox.strategies.staleWhileRevalidate({
    // Use a custom cache name
    cacheName: CSS_CACHE,
  })
);

workbox.routing.registerRoute(
  // Cache image files
  /.*\.(?:png|jpg|jpeg|svg|gif)/,
  // Use the cache if it's available
  workbox.strategies.cacheFirst({
    // Use a custom cache name
    cacheName: IMAGE_CACHE,
    plugins: [
      new workbox.expiration.Plugin({
        // Cache only 100 images
        maxEntries: 100,
        // Cache for a maximum of a week
        maxAgeSeconds: 7 * 24 * 60 * 60,
      })
    ],
  })
);

//// remove old caches https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API/Using_Service_Workers
this.addEventListener('activate', function(event) {
  var cacheWhitelist = [CSS_CACHE, IMAGE_CACHE, JS_CACHE];

  event.waitUntil(
    caches.keys().then(function(keyList) {
      return Promise.all(keyList.map(function(key) {
        if (cacheWhitelist.indexOf(key) === -1) {
          return caches.delete(key);
        }
      }));
    })
  );
});
