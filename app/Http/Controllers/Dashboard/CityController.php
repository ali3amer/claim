<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->select != null) {
            return City::all();
        } elseif ($request->state != null) {
            return City::where('state_id', $request->state)->paginate(10);
        } elseif ($request->name != '') {
            return City::where('name', 'LIKE', '%' . $request->name . '%')->latest()->paginate(10);
        } else {
            return City::paginate(10);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'state_id' => 'required',
        ]);

        $user = City::create([
            'name' => $request['name'],
            'state_id' => $request['state_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
//        return $city->units()->get();
        return Unit::where('city_id', $city->id)->get()->keyBy('id');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'state_id' => 'required',
        ]);
        $city->update([
            'name' => $request->name,
            'state_id' => $request->state_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
    }
}
