<?php
namespace App\Http\Services;

use App\Repositories\Event\IEventRepository;

class EventImportService
{

    public function __construct(private readonly IEventRepository $eventRepository)
    {
    }

    /**
     * import event list from csv file
     *
     * @param  mixed $request
     * @return void
     */
    public function import($request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);
        // Parse and process the CSV file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Read the CSV file
            $csvData = array_map('str_getcsv', file($file));

            // Remove header row if exists
            $header = array_shift($csvData);

            // Process each row of the CSV data
            foreach ($csvData as $row) {
                // Create or update event reminder from CSV data
                $this->eventRepository->create([
                    'title' => $row[0], // Assuming the first column contains event title
                    'description' => $row[1], // Assuming the second column contains event description
                    'event_date' => $row[2], // Assuming the third column contains event date
                    'reminders_email' => $row[3], // Assuming the third column contains reminder's email
                ]);
            }

        }

    }
}
