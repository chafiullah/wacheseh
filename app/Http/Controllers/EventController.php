<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventType;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($session_id)
    {
        $events = Event::with('type', 'session')->select('id', 'type_id', 'starts', 'ends', 'remarks')->where('session_id', $session_id)->get();
        $types = EventType::all();
        return view('semester_events.index', compact('events', 'session_id', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Event::create([
            'type_id' => $request->type_id,
            'session_id' => $request->session_id,
            'starts' => $request->starts,
            'ends' => $request->ends,
            'remarks' => $request->remarks
        ]);
        toastr()->success('Success', 'Event added successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        $types = EventType::all();
        return view('semester_events.edit', compact('event', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Event::where('id', $id)->update([
                'type_id' => $request->type_id,
                'session_id' => $request->session_id,
                'starts' => $request->starts,
                'ends' => $request->ends,
                'remarks' => $request->remarks
            ]);
            toastr()->success('Updated', 'Event updated successfully');
            return redirect()->route('semester-event.index', $request->session_id);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::destroy($id);
        toastr()->error('Deleted', 'Event deleted');
        return redirect()->back();
    }
}
