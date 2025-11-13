<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use App\Models\EventParticipant;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
public function index(Request $request)
{
    $query = EventParticipant::with(['event', 'member']);

    if ($request->filled('event')) {
        $query->where('event_id', $request->event);
    }

    $participants = $query->get();

    return view('event_participants.index', compact('participants'));
}


  public function create(Request $request)
{
    $events = Event::all();

    // If event_id is selected (e.g., via query string or JS)
    $eventId = $request->input('event_id');

    if ($eventId) {
        $members = Member::whereNotIn('member_id', function ($query) use ($eventId) {
            $query->select('member_id')
                  ->from('event_participants')
                  ->where('event_id', $eventId);
        })->get();
    } else {
        $members = Member::all();
    }

    return view('event_participants.create', compact('events', 'members', 'eventId'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'member_id' => 'required|exists:members,member_id',
            'attended' => 'nullable|boolean',
        ]);

        EventParticipant::create($validated);
        return redirect()->route('event_participants.index')->with('success', 'Participant added successfully.');
    }

    public function edit(EventParticipant $event_participant)
    {
        $events = Event::all();
        $members = Member::all();
        return view('event_participants.edit', compact('event_participant', 'events', 'members'));
    }

    public function update(Request $request, EventParticipant $event_participant)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'member_id' => 'required|exists:members,member_id',
            'attended' => 'nullable|boolean',
        ]);

        $event_participant->update($validated);
        return redirect()->route('event_participants.index')->with('success', 'Participant updated successfully.');
    }

    public function destroy(EventParticipant $event_participant)
    {
        $event_participant->delete();
        return redirect()->route('event_participants.index')->with('success', 'Participant deleted successfully.');
    }


    public function getAvailableMembers($eventId)
{
    $members = Member::whereNotIn('member_id', function ($q) use ($eventId) {
        $q->select('member_id')
          ->from('event_participants')
          ->where('event_id', $eventId);
    })->get(['member_id', 'full_name']);

    return response()->json($members);
}



}
