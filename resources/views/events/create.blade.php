@extends('layout.master') 
@section('body')
<div>
    <h1>Create Event</h1>
    @include('partials.errors')
     <form action="{{route('events.store')}}" class="form-group"  method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-12 py-2">
                <label for="title" class="font-bold mb-2">Title :</label><br>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Title"
                    name="title"
                    id="title"
                />
            </div>
            <div class="col-12 py-2">
                <label for="description" class="font-bold mb-2">Description :</label><br>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                    placeholder="Description"
                ></textarea>
            </div>
            <div class="col-6 py-2">
                <label for="event_date" class="font-bold mb-2">Event Date :</label><br>
                <input
                    class="form-control"
                    type="datetime-local"
                    id="event_date"
                    name="event_date"
                />
            </div>
            <div class="col-6 py-2">
                <label for="reminders_email" class="font-bold mb-2">Reminder's Email :</label><br>
                <input
                    type="email"
                    class="form-control"
                    placeholder="Reminder's Email"
                    name="reminders_email"
                    id="reminders_email"
                />
            </div>
        </div>
        <div class="text-end">
            <a href="{{route('events.index')}}" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary">Add Event</button>
        </div>
    </form>
    <script>
        if ('serviceWorker' in navigator && 'SyncManager' in window) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(registration => {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(error => {
                    console.log('Service Worker registration failed:', error);
                });
        }

        const form = document.getElementById('event-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const event = {
                event_id: `EVT-${Date.now()}`,
                title: document.getElementById('title').value,
                description: document.getElementById('description').value,
                event_date: document.getElementById('event_date').value,
                reminders_email: document.getElementById('reminders_email').value,
            };

            if ('serviceWorker' in navigator && 'SyncManager' in window) {
                const db = await openDB('eventDB', 1, {
                    upgrade(db) {
                        if (!db.objectStoreNames.contains('events')) {
                            db.createObjectStore('events', { keyPath: 'event_id' });
                        }
                    },
                });
                const tx = db.transaction('events', 'readwrite');
                tx.store.add(event);
                await tx.done;

                navigator.serviceWorker.ready.then(swRegistration => {
                    swRegistration.sync.register('sync-events');
                });
            } else {
                fetch('/api/events', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(event),
                })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error:', error));
            }

            form.reset();
        });

        async function openDB(name, version) {
            return new Promise((resolve, reject) => {
                const request = indexedDB.open(name, version);
                request.onupgradeneeded = () => {
                    const db = request.result;
                    if (!db.objectStoreNames.contains('events')) {
                        db.createObjectStore('events', { keyPath: 'event_id' });
                    }
                };
                request.onsuccess = () => resolve(request.result);
                request.onerror = () => reject(request.error);
            });
        }
    </script>
</div>
@endsection
