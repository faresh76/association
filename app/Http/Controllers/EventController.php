<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\CommitteeMember;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
public function index()
{
    $events = Event::query()
        ->with(['organizer.member',  'participants.member','organizer.role'])
        ->orderBy('event_date', 'desc')
        ->get();

    return view('events.index', compact('events'));
}


    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        // Join committee_members with members to get full names
        $committeeMembers = CommitteeMember::select('committee_members.*', 'members.full_name')
            ->join('members', 'committee_members.member_id', '=', 'members.member_id')
            ->orderBy('members.full_name', 'asc')
            ->get();

        return view('events.create', compact('committeeMembers'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organized_by' => 'required|exists:committee_members,id',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $committeeMembers = CommitteeMember::select('committee_members.*', 'members.full_name')
            ->join('members', 'committee_members.member_id', '=', 'members.member_id')
            ->orderBy('members.full_name', 'asc')
            ->get();

        return view('events.edit', compact('event', 'committeeMembers'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organized_by' => 'required|exists:committee_members,id',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
}
