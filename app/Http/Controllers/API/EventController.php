<?php

namespace App\Http\Controllers\API;

use App\Group;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __invoke(Request $request, Group $group)
    {
        $group = $group->load('parties');

        $events = $group->parties->sortByDesc('event_date')->map(function($event) {
            return (object) [
              'id' => $event->idevents,
              'location' => $event->FriendlyLocation,
            ];
        })->values()->toJson();

        return response()->json([
            'events' => $events,
        ]);
    }
}
