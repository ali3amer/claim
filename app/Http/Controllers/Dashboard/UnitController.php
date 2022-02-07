<?php

namespace App\Http\Controllers\Dashboard;

use App\Center;
use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->select == 'all') {
            return Unit::all()->keyBy('id');
        } elseif ($request->city != null) {
            return Unit::where('city_id', $request->city)->paginate(10);
        } elseif ($request->name != '') {
            return Unit::where('name', 'LIKE', '%' . $request->name . '%')->latest()->paginate(10);
        } else {
            return Unit::paginate(10);
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
            'city_id' => 'required',
        ]);

        $user = Unit::create([
            'name' => $request['name'],
            'city_id' => $request['city_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return Center::where('unit_id', $unit->id)->get()->keyBy('id');
//        return $unit->centers()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'city_id' => 'required',
        ]);
        $unit->update([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
    }
}
