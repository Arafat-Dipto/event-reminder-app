<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Services\EventImportService;
use App\Models\Event;
use App\Repositories\Event\IEventRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * __construct
     *
     * @param  IEventRepository $eventRepository
     * @return void
     */
    public function __construct(private readonly IEventRepository $eventRepository, private EventImportService $eventImportService)
    {
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $events = $this->eventRepository->allEvents();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(EventCreateRequest $request)
    {
        try {
            $event = $this->eventRepository->create([
                'title'           => $request->title,
                'description'     => $request->description,
                'event_date'      => $request->event_date,
                'reminders_email' => $request->reminders_email,
            ]);

            return redirect()->route('events.index')->with('success', 'Successfully created event');
        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    public function show($eventId)
    {
        $event = $this->eventRepository->find($eventId);

        if (!$event) {
            throw new \Exception("Event not found with ID: " . $eventId);
        }

        return view('events.edit', $data = [
            'event' => $event,
        ]);
    }

    public function update(EventUpdateRequest $request, $eventId)
    {
        try {
            $this->eventRepository->update($eventId, [
                'title'           => $request->title,
                'description'     => $request->description,
                'event_date'      => $request->event_date,
                'reminders_email' => $request->reminders_email,
            ]);
            return redirect()->back()->with('success', 'Successfully updated event');
        } catch (\Exception $e) {

            return $e->getMessage();

        }

    }

    public function destroy($eventId)
    {
        $this->eventRepository->delete($eventId);
        return redirect()->route('events.index')->with('success', 'Successfully deleted event');

    }

    public function sync(Request $request)
    {
        try {

            $events = $request->all();

            foreach ($events as $eventData) {
                // Validate each event data
                $validated = Validator::make($eventData, [
                    'title'           => 'required|string|max:255',
                    'description'     => 'required|string|max:255',
                    'event_date'      => 'required|date',
                    'reminders_email' => 'required|email',
                ])->validate();

                // Create a new event with the validated data
                $event                  = new Event();
                $event->title           = $validated['title'];
                $event->description     = $validated['description'];
                $event->event_date      = $validated['event_date'];
                $event->reminders_email = $validated['reminders_email'];
                $event->save();
            }

            // Return a JSON response indicating success
            return response()->json(['message' => 'Events synced successfully'], 201);
        } catch (\Exception $e) {

            return $e->getMessage();

        }

    }

    public function import(Request $request)
    {
        try {
            $this->eventImportService->import($request);
            return redirect()->back()->with('success', 'Events imported successfully.');
        } catch (\Exception $e) {

            // If file processing fails, redirect back with error message
            return redirect()->back()->with('error', 'Failed to import events. Please try again.');

        }

    }

}
