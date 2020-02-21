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

        return response()->json([
            'events' => $group->parties->pluck('FriendlyLocation', 'idevents')->toJson(),
        ]);
    }
}
