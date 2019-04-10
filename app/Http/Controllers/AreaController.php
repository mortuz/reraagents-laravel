<?php

namespace App\Http\Controllers;

use App\Area;
use Session;
use Illuminate\Http\Request;
use App\State;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('area.index')->with('areas', Area::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('area.create')->with('states', State::all());
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
            'state' => 'required',
            'city' => 'required|min:1',
        ]);

        Area::create([
            'area' => $request->name,
            'slug' => str_slug($request->name),
            'state_id' => $request->state,
            'city_id' => $request->city
        ]);

        Session::flash('success', 'Area successfully added');
        return redirect()->route('area.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('area.edit')->with('area', $area)->with('states', State::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'city' => 'required|min:1',
        ]);


        $area->area = $request->name;
        $area->city_id = $request->city;
        $area->state_id = $request->state;
        $area->slug = str_slug($request->name);

        $area->save();

        Session::flash('success', 'Area successfully updated');
        return redirect()->route('area.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();
        Session::flash('success', 'Area successfully deleted.');

        return redirect()->back();

    }
}
