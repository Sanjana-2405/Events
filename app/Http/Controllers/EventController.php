<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $events->transform(function ($event) {
            $event->skills = json_decode($event->skills, true);
            return $event;
        });
        return response()->json($events, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nameOfOrganization' => 'required|string|max:255',
                'eventDetail' => 'required|string|min:5',
                'location' => 'required|string|max:255',
                'date' => 'required|date',
                'startTime' => 'required|date_format:H:i:s',
                'endTime' => 'required|date_format:H:i:s|after:startTime',
                'skills' => 'required|array',
                'skills.*' => 'string',
            ]);

            $event = Event::create([
                'nameOfOrganization' => $validatedData['nameOfOrganization'],
                'eventDetail' => $validatedData['eventDetail'],
                'location' => $validatedData['location'],
                'date' => $validatedData['date'],
                'startTime' => $validatedData['startTime'],
                'endTime' => $validatedData['endTime'],
                'skills' => json_encode($validatedData['skills']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully!',
                'data' => $event
            ], Response::HTTP_CREATED);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed!',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create event!',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], Response::HTTP_NOT_FOUND);
        }
        $event->skills = json_decode($event->skills, true);
        return response()->json($event, Response::HTTP_OK);
    }


    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], Response::HTTP_NOT_FOUND);
        }
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully'], Response::HTTP_OK);
    }
}
