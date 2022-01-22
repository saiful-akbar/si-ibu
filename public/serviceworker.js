var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    "/offline",
    "/css/app.css",
    "/js/app.js",

    // Assets css
    "/assets/css/icons.min.css",
    "/assets/css/app.min.css",
    "/assets/css/app-dark.min.css",
    "/assets/css/main.css",

    // Assets js
    "/assets/js/app.min.js",
    "/assets/js/main.js",
    "/assets/js/vendor.min.js",
    "/assets/js/pages/akunBelanja.js",
    "/assets/js/pages/budget.js",
    "/assets/js/pages/dashboard.js",
    "/assets/js/pages/divisi.js",
    "/assets/js/pages/transaksi.js",
    "/assets/js/pages/user.js",

    // Assets image
    "/assets/images/avatars/avatar_default.webp",
    "/assets/images/bg/offline.svg",

    // Icons
    "/assets/images/icons/icon-16x16.png",
    "/assets/images/icons/icon-32x32.png",
    "/assets/images/icons/icon-57x57.png",
    "/assets/images/icons/icon-60x60.png",
    "/assets/images/icons/icon-72x72.png",
    "/assets/images/icons/icon-76x76.png",
    "/assets/images/icons/icon-96x96.png",
    "/assets/images/icons/icon-114x114.png",
    "/assets/images/icons/icon-120x120.png",
    "/assets/images/icons/icon-128x128.png",
    "/assets/images/icons/icon-144x144.png",
    "/assets/images/icons/icon-152x152.png",
    "/assets/images/icons/icon-180x180.png",
    "/assets/images/icons/icon-192x192.png",
    "/assets/images/icons/icon-384x384.png",
    "/assets/images/icons/icon-512x512.png",

    // Splash screen
    "/assets/images/icons/splash-640x1136.png",
    "/assets/images/icons/splash-750x1334.png",
    "/assets/images/icons/splash-1242x2208.png",
    "/assets/images/icons/splash-1125x2436.png",
    "/assets/images/icons/splash-828x1792.png",
    "/assets/images/icons/splash-1242x2688.png",
    "/assets/images/icons/splash-1536x2048.png",
    "/assets/images/icons/splash-1668x2224.png",
    "/assets/images/icons/splash-1668x2388.png",
    "/assets/images/icons/splash-2048x2732.png",
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});
