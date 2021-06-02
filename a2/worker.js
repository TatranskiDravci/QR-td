const CACHE_NAME = "offline-cache";

let urlsToCache = [
    "/team/js/qr-scanner/qr-scanner.umd.min.js",
    "/team/js/handle-qr.js",
    "/team/js/ajax.js",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js",
    "/team/index.php",
    "/css.css",
    "/idem.png",
    "/manifest.json",
    "/team/js/qr-scanner/qr-scanner-worker.min.js",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
];

self.addEventListener("install", event => {
    event.waitUntil(( async () => {
        console.log("install");
        const cache = await caches.open(CACHE_NAME);
        await cache.addAll(urlsToCache);
    })());
});

self.addEventListener("fetch", event => {
    console.log(event);
    event.respondWith(
        caches.match(event.request).then( response => {
            if(response) {
                return response;
            }
            return fetch(event.request);
        })
    );
});

self.addEventListener('activate', event => {
    console.log('Claiming control');
    return self.clients.claim();
});