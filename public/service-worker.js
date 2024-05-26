self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open("event-cache").then((cache) => {
            return cache.addAll([
                "/",
                "/index.html",
                "/css/app.css",
                "/js/app.js",
            ]);
        })
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});

self.addEventListener("sync", (event) => {
    if (event.tag === "sync-events") {
        event.waitUntil(syncEvents());
    }
});

async function syncEvents() {
    const db = await openDB("eventDB", 1);
    const tx = db.transaction("events", "readonly");
    const store = tx.objectStore("events");
    const events = await store.getAll();

    const response = await fetch("/api/events/sync", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ events }),
    });

    if (response.ok) {
        const tx = db.transaction("events", "readwrite");
        const store = tx.objectStore("events");
        await store.clear();
    }
}

async function openDB(name, version) {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(name, version);
        request.onupgradeneeded = () => {
            const db = request.result;
            if (!db.objectStoreNames.contains("events")) {
                db.createObjectStore("events", { keyPath: "event_id" });
            }
        };
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}
