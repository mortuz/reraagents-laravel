<?php

namespace App\Http\Controllers;

use App\City;
use App\State;
use Session;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cities.index')->with('cities', City::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.create')->with('states', State::all());
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
            'name' => 'required',
            'state' => 'required'
        ]);

        City::create([
            'name' => $request->name,
            'state_id' => $request->state,
            'slug' => str_slug($request->name),
            'status' => $request->status
        ]);

        Session::flash('success', 'City successfully created.');
        return redirect()->route('cities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('cities.edit')->with('states', State::all())
            ->with('city', $city);
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
            'name' => 'required',
            'state' => 'required'
        ]);

        $city->name = $request->name;
        $city->state_id = $request->state;
        $city->status = $request->status ? 1 : 0;
        $city->save();

        Session::flash('success', 'City successfully Updated.');
        return redirect()->route('cities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        Session::flash('success', `{$city->name} has been successfully deleted.`);
        $city->delete();
        return redirect()->back();
    }

    /**
     * Set status=1 to active the state.
     *
     * @param  \App\City  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $city = City::find($id);

        $city->status = 1;
        $city->save();

        Session::flash('success', `{$city->name} is now active.`);

        return redirect()->back();
    }

    /**
     * Set status=0 to inactive .
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function inactive($id)
    {
        $city = City::find($id);

        $city->status = 0;
        $city->save();

        Session::flash('warning', `{$city->name} is now inactive.`);

        return redirect()->back();
    }
}
