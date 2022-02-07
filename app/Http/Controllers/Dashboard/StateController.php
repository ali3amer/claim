<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use App\Http\Controllers\Controller;
use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->select != null) {
            return State::all();
        } elseif ($request->state != null) {
            return City::where('state_id', $request->state)->get()->keyBy('id');
        } elseif ($request->name != '') {
            return State::where('name', 'LIKE', '%' . $request->name . '%')->latest()->paginate(10);
        } else {
            return State::paginate(10);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
        ]);

        $user = State::create([
            'name' => $request['name'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\State $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\State $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\State $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
        ]);
        $state->update([
            'name' => $request->name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();
    }
}
