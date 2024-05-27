// public/js/indexeddb.js

const dbName = "eventReminderDB";
const dbVersion = 1;
let db;

function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(dbName, dbVersion);

        request.onupgradeneeded = (event) => {
            db = event.target.result;
            const objectStore = db.createObjectStore("events", {
                keyPath: "id",
                autoIncrement: true,
            });
            objectStore.createIndex("by_date", "date", { unique: false });
        };

        request.onsuccess = (event) => {
            db = event.target.result;
            resolve(db);
        };

        request.onerror = (event) => {
            reject(event.target.error);
        };
    });
}

function saveEvent(event) {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction(["events"], "readwrite");
        const objectStore = transaction.objectStore("events");
        const request = objectStore.add(event);

        request.onsuccess = () => {
            resolve();
        };

        request.onerror = (event) => {
            reject(event.target.error);
        };
    });
}

function getEvents() {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction(["events"], "readonly");
        const objectStore = transaction.objectStore("events");
        const request = objectStore.getAll();

        request.onsuccess = () => {
            resolve(request.result);
        };

        request.onerror = (event) => {
            reject(event.target.error);
        };
    });
}

function deleteEvents() {
    return new Promise((resolve, reject) => {
        const transaction = db.transaction(["events"], "readwrite");
        const objectStore = transaction.objectStore("events");
        const request = objectStore.clear();

        request.onsuccess = () => {
            resolve();
        };

        request.onerror = (event) => {
            reject(event.target.error);
        };
    });
}
