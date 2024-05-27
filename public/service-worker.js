// public/service-worker.js
const CACHE_NAME = "event-reminder-cache-v1";
const urlsToCache = ["/", "/css/app.css", "/js/app.js", "/js/indexeddb.js"];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                return cache.add(urlsToCache).catch((error) => {
                    console.error("Failed to cache resources:", error);
                    throw error; // Ensure the promise rejects to handle the error correctly
                });
            })
            .catch((error) => {
                console.error("Error opening cache:", error);
            })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            if (response) {
                return response;
            }
            return fetch(event.request);
        })
    );
});
