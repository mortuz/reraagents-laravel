<?php

namespace App\Http\Controllers;

use App\Landmark;
use Illuminate\Http\Request;
use App\State;
use Session;

class LandmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('landmark.index')->with('landmarks', Landmark::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('landmark.create')->with('states', State::all());
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

        Landmark::create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'state_id' => $request->state,
            'city_id' => $request->city
        ]);

        Session::flash('success', 'Landmark successfully added');
        return redirect()->route('landmark.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Landmark  $landmark
     * @return \Illuminate\Http\Response
     */
    public function show(Landmark $landmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Landmark  $landmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Landmark $landmark)
    {
        return view('landmark.edit')->with('landmark', $landmark)->with('states', State::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Landmark  $landmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Landmark $landmark)
    {
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'city' => 'required|min:1',
        ]);


        $landmark->name = $request->name;
        $landmark->city_id = $request->city;
        $landmark->state_id = $request->state;
        $landmark->slug = str_slug($request->name);

        $landmark->save();

        Session::flash('success', 'Landmark successfully updated');
        return redirect()->route('landmark.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Landmark  $landmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Landmark $landmark)
    {
        $landmark->delete();
        Session::flash('success', 'Landmark successfully deleted.');

        return redirect()->back();

    }
}
