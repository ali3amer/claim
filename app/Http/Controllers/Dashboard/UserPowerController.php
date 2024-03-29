<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use App\User_Power;
use Illuminate\Http\Request;

class UserPowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User_Power::where('user_id', $request->user)->first();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_Power  $user_Power
     * @return \Illuminate\Http\Response
     */
    public function show(User_Power $user_Power)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User_Power  $user_Power
     * @return \Illuminate\Http\Response
     */
    public function edit(User_Power $user_Power)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_Power  $user_Power
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_Power $user_Power)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_Power  $user_Power
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_Power $user_Power)
    {
        //
    }
}
