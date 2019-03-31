<?php

namespace App\Http\Controllers;

use App\State;
use Session;
use Illuminate\Http\Request;
use App\City;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('states.index')->with('states', State::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('states.create');
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
            'name' => 'required|max:255'
        ]);

        State::create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'status' => $request->status == 1 ? 1 : 0
        ]);

        Session::flash('success', 'State successfully created.');

        return redirect()->route('states.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('states.edit')->with('state', State::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $state = State::find($id);

        $state->name = $request->name;
        $state->slug = str_slug($request->name);
        $state->status = ($request->status == 1) ? 1 : 0;

        $state->save();

        Session::flash('success', 'State successfully updated.');

        return redirect()->route('states.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::find($id);

        foreach ($state->cities as $city) {
            $city = City::find($city);
            $city->delete();
        }

        $state->delete();

        Session::flash('success', 'State successfully deleted.');

        return redirect()->route('states.index');
    }

    /**
     * Set status=1 to active the state.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $state = State::find($id);

        $state->status = 1;
        $state->save();

        Session::flash('success', `{$state->name} is now active.`);

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
        $state = State::find($id);

        $state->status = 0;
        $state->save();

        Session::flash('warning', `{$state->name} is now inactive.`);

        return redirect()->back();
    }
}
