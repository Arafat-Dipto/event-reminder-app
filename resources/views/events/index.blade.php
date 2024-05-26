 @extends('layout.master')
 @section('body')
 <style>
    .event_pagination {
        display: flex;
        justify-content: center;
    }
 </style>
    <div class="d-flex justify-content-between align-items-center mb-3">
        
        <h2>Event List</h1>
            
        <!-- Modal -->
        <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Import Events
        </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Import Event List with csv file</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('events.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group py-3">
                            <label for="file">Choose CSV file:</label>
                            <input type="file" class="form-control-file" id="file" name="file">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import Events</button>
                        </div>
                    </form>
                </div>
                
                </div>
            </div>
            </div>
            <a href="{{route('events.create')}}" class="btn btn-primary">Create</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Event Id</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Event Date</th>
                <th scope="col">Reminder's Email</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($events)}} --}}
            @foreach($events as $event)
            <tr>
                <td>{{$event['event_id']}}</th>
                <td>{{$event['title']}}</td>
                <td>{{$event['description']}}</td>
                <td>{{$event['event_date']}}</td>
                <td>{{$event['reminders_email']}}</td>
                <td>
                    <a class="btn btn-primary btm-sm mr-2" href="{{route('events.show',$event['id'])}}">Edit</a>
                    <a onclick="return confirm('are you sure?');" class="btn btn-danger btm-sm mr-2" href="{{route('events.destroy',$event['id'])}}">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="event_pagination">
        
            {{ $events->links() }}
    </div>
@endsection