<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use Auth;

class EventController extends Controller
{
    // the list of events
    public function index()
    {
        
        $events = Event::where('user_id', Auth::id())->get();
        return view('main.event', compact('events'));
    }

    // Store new event
    public function store(Request $request)
    {
        $request->validate([
            'eventname' => 'required',
            'location' => 'required',
            'datetime' => 'required',
            'remarks' => 'nullable',
            'attachment' => 'nullable|file',
        ]);

        
        $event = new Event();
        $event->user_id = Auth::id();
        $event->eventname = $request->eventname;
        $event->location = $request->location;
        $event->datetime = $request->datetime;
        $event->remarks = $request->remarks;

        if ($request->hasFile('attachment')) {
            // Delete the old attachment if it exists
            if ($event->attachment) {
                Storage::disk('public')->delete($event->attachment);
            }

            // Store the new attachment
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $event->attachment = $filePath;
        }

        $event->save();

        return redirect()->route('event.index')->with('success', 'Event updated successfully!');
    }

    // Delete event
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Event deleted successfully!');
    }


    
}
