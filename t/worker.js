const CACHE_NAME = "offline-cache";

let urlsToCache = [
    "/team/js/qr-scanner/qr-scanner.umd.min.js",
    "/team/js/handle-qr.js",
    "/team/js/ajax.js",
    "/team/js/main.js",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js",
    "/team/index.php",
    "/css.css",
    "/idem.png",
    "/manifest.json",
    "/team/js/qr-scanner/qr-scanner-worker.min.js",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
];

self.addEventListener("install", event => {
    console.log("worker.js >> cache >> status: cached website");
    event.waitUntil( () => {
        caches.open(CACHE_NAME).then( cache => {
            cache.addAll(urlsToCache);
        });
    });
});

self.addEventListener("fetch", event => {
    event.respondWith(
        caches.open(CACHE_NAME).then( cache => {
            return fetch(event.request)
            .then( response => {
                console.log("worker.js >> fetch >> status: network fetch");
                console.log("worker.js >> cache >> status: updated cache");
                cache.put(event.request, response.clone());
                return response;
            })
            .catch( () => {
                console.log("worker.js >> fetch >> status: cache fallback");
                return cache.match(event.request);
            })
        })
    );
});

self.addEventListener('activate', () => {
    return self.clients.claim();
});