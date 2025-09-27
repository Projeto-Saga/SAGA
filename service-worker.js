const CACHE_NAME = 'saga-cache-v1';
const urlsToCache = [
  '/',
  '/index.php',
  '/lobby.php',
  '/calendar.php',
  '/courses.php',
  '/profile.php',
  '/projects.php',
  '/requests.php',
  '/css/styles.css',
  '/css/studnt.css',
  '/css/homepg.css',
  '/css/mybook.css',
  '/css/calend.css',
  '/css/rqests.css',
  '/css/rspnsv.css',
  '/js/dataformat.js',
  '/js/animations.js',
  '/js/calendario.js',
  '/js/lobby.js',
  '/js/mybook.js',
  '/js/profile.js',
  '/js/requests.js',
  '/img/logos/logo-n-colors-192.png',
  '/img/logos/logo-n-colors-512.png'
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
