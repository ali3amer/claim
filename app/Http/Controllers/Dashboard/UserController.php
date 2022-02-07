<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use App\User_Power;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->name != '') {
            return User::where('name','LIKE', '%' . $request->name . '%')->latest()->paginate(10);
        } else {
            return User::with('powers')->paginate(10);
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
//        dd($request);
        $this->validate($request, [
            'name' => 'required|string|max:191',
//            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
//            'permissions' => 'required|min:1',
            'state_id' => 'required',
            'power' => 'required'
        ]);


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'state_id' => $request['state_id'],
            'power' => $request['power']
        ]);

        if ($user->power == 'city') {
            User_Power::create([
                'user_id' => $user->id,
                'city_id' => $request->city_id
            ]);
        }

//        $user->attachRole('admin');

//        $user->syncPermissions($request->permissions);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return $permissions = $user->allPermissions()->pluck('name');
//        $data = [];
//        foreach ($permissions as $permission) {
//            $data[$permission] = $permission;
//        }
//        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
            'state_id' => 'state_id',
            'power' => 'power'
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'state_id' => $request->state_id,
            'power' => $request->power
        ]);

        if ($user->power) {
            User_Power::create([
                'user_id' => $user->id,
                'city_id' => $request->city_id
            ]);
        }

//        $user->syncPermissions($request->permissions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
