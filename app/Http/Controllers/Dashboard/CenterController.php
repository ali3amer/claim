<?php

namespace App\Http\Controllers\Dashboard;

use App\Center;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->unit != null) {
            return Center::where('name', 'LIKE', '%' . $request->name . '%')->where('unit_id', $request->unit)->paginate(10);
        } elseif ($request->name != '') {
            return Center::where('name', 'LIKE', '%' . $request->name . '%')->where('unit_id', $request->unit)->latest()->paginate(10);
        } else {
            return Center::paginate(10);
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
            'unit_id' => 'required',
            'type_id' => 'required',
            'category_id' => 'required',
        ]);

        $user = Center::create([
            'name' => $request['name'],
            'unit_id' => $request['unit_id'],
            'type_id' => $request['type_id'],
            'category_id' => $request['category_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function show(Center $center)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function edit(Center $center)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Center $center)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'unit_id' => 'required',
            'type_id' => 'required',
            'category_id' => 'required',
        ]);
        $center->update([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
            'type_id' => $request->type_id,
            'category_id' => $request->category_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function destroy(Center $center)
    {
        $center->delete();
    }
}
