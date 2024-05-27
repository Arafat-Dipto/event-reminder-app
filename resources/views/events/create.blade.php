@extends('layout.master') @section('body')
<div>
    <h1>Create Event</h1>
    @include('partials.errors')
    <div>
        <form
            id="event-form"
            action="{{ route('events.store') }}"
            class="form-group"
            method="POST"
        >
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12 py-2">
                    <label for="title" class="font-bold mb-2">Title :</label
                    ><br />
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Title"
                        name="title"
                        id="title"
                    />
                </div>
                <div class="col-12 py-2">
                    <label for="description" class="font-bold mb-2"
                        >Description :</label
                    ><br />
                    <textarea
                        class="form-control"
                        id="description"
                        name="description"
                        placeholder="Description"
                    ></textarea>
                </div>
                <div class="col-6 py-2">
                    <label for="event_date" class="font-bold mb-2"
                        >Event Date :</label
                    ><br />
                    <input
                        class="form-control"
                        type="datetime-local"
                        id="event_date"
                        name="event_date"
                    />
                </div>
                <div class="col-6 py-2">
                    <label for="reminders_email" class="font-bold mb-2"
                        >Reminder's Email :</label
                    ><br />
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
                <a href="{{ route('events.index') }}" class="btn btn-primary"
                    >Back</a
                >
                <button type="submit" class="btn btn-primary">Add Event</button>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/indexeddb.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            await openDB();

            document
                .getElementById("event-form")
                .addEventListener("submit", async (event) => {
                    event.preventDefault();

                    const newEvent = {
                        title: document.getElementById("title").value,
                        description:
                            document.getElementById("description").value,
                        event_date: document.getElementById("event_date").value,
                        reminders_email:
                            document.getElementById("reminders_email").value,
                    };

                    await saveEvent(newEvent);
                    displayEvents();
                });

            displayEvents();

            window.addEventListener("online", async () => {
                const events = await getEvents();
                if (events.length > 0) {
                    const synced = await syncEvents(events);
                    if (synced) {
                        await deleteEvents();
                        window.location.href = '/events?status=success&message=Event created successfully'; // Redirect to the events list page
                    }
                }
            });

            async function displayEvents() {
                const events = await getEvents();
                const eventsList = document.getElementById("events");
                eventsList.innerHTML = "";
                events.forEach((event) => {
                    const li = document.createElement("li");
                    li.textContent = `${event.title} - ${event.description} - ${event.event_date} - ${event.reminders_email}`;
                    eventsList.appendChild(li);
                });
            }

            async function syncEvents(events) {
                try {
                    const response = await fetch("/api/events/sync", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify(events),
                    });

                    if (!response.ok) {
                        throw new Error("Failed to sync events");
                    }

                    console.log("Events synced successfully");
                    return true;
                } catch (error) {
                    console.error("Error syncing events:", error);
                    return false;
                }
            }
        });
    </script>
</div>
@endsection
