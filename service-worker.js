const CACHE_NAME = 'saga-cache-v1';
const urlsToCache = [
  '/',                // index.php
  '/index.php',
  '/lobby.php',
  '/calendar.php',
  '/css/styles.css',  // coloque arquivos específicos, não pastas
  '/js/dataformat.js',
  '/js/animations.js',
  '/img/logos/logo-192.png',
  '/img/logos/logo-512.png'
];


self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => response || fetch(event.request))
  );
});
