<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Center;
use App\City;
use App\Client;
use App\Client_Violation;
use App\Detail;
use App\Field;
use App\Http\Controllers\Controller;
use App\State;
use App\Table;
use App\Type;
use App\Violation;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->check != '' && $request->date != '' && $request->center != '' && $request->number != '') {

            if ($request->editMode == true) {
                $count = Client::where('id', '!=', $request->id)->where('number', $request->number)->where('center', $request->center)->where('date', $request->date)->count();

                if ($count == 0) {
                    return 'true';

                } else {
                    return 'false';
                }
            } else {
                $count = Client::where('number', $request->number)->where('center', $request->center)->where('date', $request->date)->count();

                if ($count == 0) {
                    return 'true';

                } else {
                    return 'false';
                }
            }

        } elseif ($request->select == 'clients' && $request->date != '' && $request->center != '') {
            if ($request->search == '') {
                return Client::where('date', $request->date)->where('center', $request->center)->with('violations')->paginate(10);
            } else {
                return Client::where('number', $request->search)->where('date', $request->date)->where('center', $request->center)->with('violations')->paginate(10);
            }

        } else {
            $tables = Table::with('fields')->get();

            $cities = City::all()->keyBy('id');

            $states = Field::where('table_id', 11)->get();

            $violations = Violation::all()->keyBy('id');

            $sections = Field::where('table_id', 2)->get();

            $types = Type::all()->keyBy('id');

            $categories = Category::all()->keyBy('id');

            $ages = Field::where('table_id', 1)->get();


            return response()->json(['tables' => $tables, 'cities' => $cities, 'states' => $states, 'sections' => $sections, 'ages' => $ages, 'violations' => $violations, 'types' => $types, 'categories' => $categories]);

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
            'number' => 'required',
            'age' => 'required',
            'amount' => 'required',
            'state' => 'required',
            'gender' => 'required',
            'section' => 'required',
            'center' => 'required',
            'date' => 'required'
        ]);

            $client = Client::create([
                'number' => $request['number'],
                'amount' => $request['amount'],
                'age' => $request['age'],
                'gender' => $request['gender'],
                'state' => $request['state'],
                'section' => $request['section'],
                'center' => $request['center'],
                'date' => $request['date'],
            ]);

            foreach ($request->name as $name) {
                Detail::create([
                    'name' => $name,
                    'client_id' => $client->id,
                ]);
            }

            foreach ($request->violations as $key => $violation) {
                Client_Violation::create([
                    'violation_id' => $key,
                    'amount' => $violation,
                    'client_id' => $client->id,
                ]);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $rows = Detail::where('client_id', $client->id)->get();
        $details = [];
        foreach ($rows as $row) {
            $details[] = $row['name'];
        }
        return $details;
//        dd($client->with('details:name')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'number' => 'required',
            'age' => 'required',
            'amount' => 'required',
            'state' => 'required',
            'gender' => 'required',
            'section' => 'required',
            'center' => 'required',
            'date' => 'required',
        ]);

        $client->update([
            'number' => $request['number'],
            'amount' => $request['amount'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'state' => $request['state'],
            'section' => $request['section'],
            'center' => $request['center'],
            'date' => $request['date'],
        ]);

        Detail::where('client_id', $client->id)->delete();

        foreach ($request->name as $name) {
            Detail::create([
                'name' => $name,
                'client_id' => $client->id,
            ]);
        }

        Client_Violation::where('client_id', $client->id)->delete();

        foreach ($request->violations as $key => $violation) {
            Client_Violation::create([
                'violation_id' => $key,
                'amount' => $violation,
                'client_id' => $client->id,
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
    }
}
