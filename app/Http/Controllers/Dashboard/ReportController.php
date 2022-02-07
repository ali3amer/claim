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

use App\Table;
use App\Type;
use App\Unit;
use App\Violation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return Table::with('fields')->get();
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
        $quarterOne = [$request->date . '-' . '01', $request->date . '-' . '02', $request->date . '-' . '03'];
        $quarterTwo = [$request->date . '-' . '04', $request->date . '-' . '05', $request->date . '-' . '06'];
        $halfOne = array_merge($quarterOne, $quarterTwo);
        $quarterThree = [$request->date . '-' . '07', $request->date . '-' . '08', $request->date . '-' . '09'];
        $quarterFour = [$request->date . '-' . '10', $request->date . '-' . '11', $request->date . '-' . '12'];
        $halfTwo = array_merge($quarterFour, $quarterThree);
        $year = array_merge($halfOne, $halfTwo);

        if ($request->type != '') {
            $types = Type::where('id', $request->type)->get()->keyBy('id');
        } else {
            $types = Type::all()->keyBy('id');
        }

        if ($request->category != '') {
            $categories = Category::where('id', $request->category)->get()->keyBy('id');

        } else {
            $categories = Category::all()->keyBy('id');
        }

        if ($request->reportOf == 'center') {

            $centers = Center::where('id', $request->center)->get()->keyBy('id');

        } elseif ($request->reportOf == 'unit') {

            $units = Unit::where('id', $request->unit)->get()->keyBy('id');

            $centers = Center::whereIn('unit_id', $units->pluck('id'))->whereIn('type_id', $types->pluck('id'))->whereIn('category_id', $categories->pluck('id'))->get()->keyBy('id');

        } elseif ($request->reportOf == 'city') {

            if ($request->city == 'all') {
                $cities = City::all()->keyBy('id');
            } else {
                $cities = City::where('id', $request->city)->get()->keyBy('id');

            }

            $units = Unit::whereIn('city_id', $cities->pluck('id'))->get()->keyBy('id');

            $centers = Center::whereIn('unit_id', $units->pluck('id'))->whereIn('type_id', $types->pluck('id'))->whereIn('category_id', $categories->pluck('id'))->get()->keyBy('id');

        }

        $totalCenters = $centers;

        $centers = $centers->pluck('id');

        if ($request->reportType == 'month') {

            $clients = Client::where('date', $request->date)->whereIn('center', $centers)->get();

        } elseif ($request->reportType == 'quarterOne') {

            $clients = Client::whereIn('date', $quarterOne)->whereIn('center', $centers)->get();

        } elseif ($request->reportType == 'quarterTwo') {

            $clients = Client::whereIn('date', $quarterTwo)->whereIn('center', $centers)->get();

        } elseif ($request->reportType == 'halfOne') {

            $clients = Client::whereIn('date', $halfOne)->whereIn('center', $centers)->get();

        } elseif ($request->reportType == 'quarterThree') {

            $clients = Client::whereIn('date', $quarterThree)->whereIn('center', $centers)->get();

        } elseif ($request->reportType == 'quarterFour') {

            $clients = Client::whereIn('date', $quarterFour)->whereIn('center', $centers)->get();

        } elseif ($request->reportType == 'halfTwo') {

            $clients = Client::whereIn('date', $halfTwo)->whereIn('center', $centers)->get();

        } elseif ($request->reportType == 'year') {

            $clients = Client::whereIn('date', $year)->whereIn('center', $centers)->get();

        }

        $ids = $clients->pluck('id');

        $fields = Field::all();

        $details = [];
        $ages = [];

        $sections = [];
        $states = [];
        $violationsFreq = [];

        $violations = Violation::all()->keyBy('id');
        $clientViolations = Client_Violation::whereIn('client_id', $ids)->get();

        foreach ($violations as $violation) {
            $count = 0;
            $amount = 0;
            foreach ($clientViolations as $client) {
                if ($client->violation_id == $violation->id) {
                    $count++;
                    $amount += $client->amount;
                }
            }
            $violationsFreq[$violation->name]['freq'] = $count;
            $violationsFreq[$violation->name]['cost'] = $amount;
        }


        foreach ($fields as $field) {

            ///=================== Start Gender
            $malesCount = 0;
            $femalesCount = 0;

            if ($field->table_id == 1) {

                foreach ($clients as $client) {
                    if ($client->gender == 1 && $client->age == $field->id) {
                        $malesCount++;
                    } elseif ($client->gender == 2 && $client->age == $field->id) {
                        $femalesCount++;
                    }
                }

                $ages[$field->id]['males'] = $malesCount;
                $ages[$field->id]['females'] = $femalesCount;

                ///=================== Start Sections

            } elseif ($field->table_id == 2) {
                $count = 0;
                $cost = 0;
                foreach ($clients as $client) {
                    if ($client->section == $field->id) {
                        $count++;
                        $cost += $client->amount;
                    }
                }
                $sections[$field->id]['freq'] = $count;
                $sections[$field->id]['cost'] = $cost;
            } elseif ($field->table_id == 11) {

                ///=================== Start States

                $count = 0;
                $cost = 0;
                foreach ($clients as $client) {
                    if ($client->state == $field->id) {
                        $count++;
                        $cost += $client->amount;
                    }
                }
                $states[$field->id]['freq'] = $count;
                $states[$field->id]['cost'] = $cost;
            } else {
                $details[$field->id] = Detail::whereIn('client_id', $ids)->where('name', $field->id)->count();
            }
        }

        $freqs = [];
        $citiesfreqs = [];
        $total = [];

        if ($request->city == 'all') {
            foreach ($cities as $city) {
                $count = 0;
                $amount = 0;
                foreach ($units as $unit) {
                    if ($city->id == $unit->city_id) {
                        foreach ($totalCenters as $center) {
                            if ($center->unit_id == $unit->id) {
                                foreach ($clients as $client) {
                                    if ($center->id == $client->center) {
                                        $count++;
                                        $amount += $client->amount;
                                    }
                                }
                            }
                        }
                    }
                    $citiesfreqs[$city->name]['freq'] = $count;
                    $citiesfreqs[$city->name]['cost'] = $amount;
                }
            }
        }


        if ($request->reportOf != 'center') {
            foreach ($types as $type) {
                foreach ($totalCenters as $center) {
                    $amount = 0;
                    $count = 0;
                    if ($type->id == $center->type_id) {
                        foreach ($clients as $client) {
                            if ($center->id == $client->center) {
                                $amount += $client->amount;
                                $count++;
                            }
                        }
                        $freqs[$type->name][$center->id]['id'] = $center->id;
                        $freqs[$type->name][$center->id]['city'] = $units[$center->unit_id]->city_id;
                        $freqs[$type->name][$center->id]['unit'] = $units[$center->unit_id]->name;
                        $freqs[$type->name][$center->id]['name'] = $center->name;
                        $freqs[$type->name][$center->id]['cost'] = $amount;
                        $freqs[$type->name][$center->id]['freq'] = $count;
                    }

                }
            }
        }

        foreach ($types as $type) {
            foreach ($categories as $category) {
                $amount = 0;
                $count = 0;
                foreach ($clients as $client) {
                    if ($totalCenters[$client->center]->category_id == $category->id && $totalCenters[$client->center]->type_id == $type->id) {
                        $amount += $client->amount;
                        $count++;
                    }
                }
                $total[$category->name . ' ' . $type->name]['cost'] = $amount;
                $total[$category->name . ' ' . $type->name]['freq'] = $count;
            }
        }



        return response()->json(['details' => $details, 'ages' => $ages, 'sections' => $sections, 'states' => $states, 'freqs' => $freqs, 'total' => $total, 'citiesfreqs' => $citiesfreqs, 'violationsFreq' => $violationsFreq]);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
