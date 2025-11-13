<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use App\Models\Announcement;
use App\Models\MemberMembership;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // Latest active announcements
        $latestAnnouncements = Announcement::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Newest expired announcements
        $expiredAnnouncements = Announcement::where('is_active', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Latest expired memberships (5)
        $latestExpiredMemberships = MemberMembership::with(['member', 'membershipType'])
            ->where('end_date', '<', $today)
            ->where('is_active', 0) // optional if you want only inactive
            ->orderBy('end_date', 'desc')
            ->take(5)
            ->get();

        // Upcoming events (5 soonest)
        $upcomingEvents = Event::withCount('participants')
            ->whereDate('event_date', '>=', $today)
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        // Newest members (5 most recent)
        $newestMembers = Member::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'latestAnnouncements', 
            'expiredAnnouncements', 
            'latestExpiredMemberships',
            'upcomingEvents', 
            'newestMembers'
        ));
    }
}
