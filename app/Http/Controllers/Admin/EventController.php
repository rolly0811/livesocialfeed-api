<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use RefreshDatabase;
    
    public function get(Request $request) {
        $active = $request->has('active') ? $request->active : 0;
        $events = Event::orderBy('start_date', 'DESC');
        if($active) {
            $events->where('start_date', '>=', now());
        }
        else {
            $events->where('end_date', '<', now());
        }

        return response()->json($events->get());
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'display_date' => 'required',
            'location' => 'required'
        ]);

        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'code' => $request->code,
            'location' => $request->location,
            'display_date' => $request->display_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => auth()->id()
        ]);

        return response()->json($event, 201);
    }

    public function update(Request $request, Event $event) {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'display_date' => 'required',
            'location' => 'required'
        ]);

        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'code' => $request->code,
            'location' => $request->location,
            'display_date' => $request->display_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json($event, 202);
    }

    public function destroy($event) {
        $event->delete();

        return response()->json(['message' => 'Record has been deleted'], 200);
    }

    public function getLatest() {
        $events = Event::where('end_date', '>=', now())->orderBy('start_date', 'ASC');

        return $events->first();
    }
}
