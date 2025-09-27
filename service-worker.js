const CACHE_NAME = 'saga-cache-v1';
const urlsToCache = [
  '/',
  '/index.php',
  '/calendar.php',
  '/couser.php',
  '/lobby.php',
  '/profile.php',
  '/projects.php',
  '/request.php',
  '/css/',
  '/js/',
  '/img/'
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
