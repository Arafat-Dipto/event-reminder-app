@extends('layout.master') 
@section('body')
<div>
    <h1>Edit Event</h1>
    @include('partials.errors')
     <form action="{{route('events.update',$event->id)}}" class="form-group"  method="POST">
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
                    value="{{ $event->title }}"
                />
            </div>
            <div class="col-12 py-2">
                <label for="description" class="font-bold mb-2">Description :</label><br>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                    placeholder="Description"
                >{{ $event->description}}</textarea>
            </div>
            <div class="col-6 py-2">
                <label for="event_date" class="font-bold mb-2">Event Date :</label><br>
                <input
                    class="form-control"
                    type="datetime-local"
                    id="event_date"
                    name="event_date"
                    value="{{ $event->event_date }}"
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
                    value="{{ $event->reminders_email }}"
                />
            </div>
        </div>
        <div class="text-end">
            <a href="{{route('events.index')}}" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary">Update Event</button>
        </div>
    </form>
</div>
@endsection
