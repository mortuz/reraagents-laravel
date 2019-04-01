<?php

namespace App\Http\Controllers;

use App\Venture;
use Illuminate\Http\Request;
use Session;
use App\State;

class VentureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ventures.index')->with('ventures', Venture::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ventures.create')->with('states', State::all());
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

        Venture::create([
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'state_id' => $request->state,
            'city_id' => $request->city
        ]);

        Session::flash('success', 'Venture successfully added');
        return redirect()->route('venture.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venture  $venture
     * @return \Illuminate\Http\Response
     */
    public function show(Venture $venture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venture  $venture
     * @return \Illuminate\Http\Response
     */
    public function edit(Venture $venture)
    {
        return view('ventures.edit')->with('venture', $venture)->with('states', State::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venture  $venture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venture $venture)
    {
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'city' => 'required|min:1',
        ]);


        $venture->name = $request->name;
        $venture->city_id = $request->city;
        $venture->state_id = $request->state;
        $venture->slug = str_slug($request->name);

        $venture->save();

        Session::flash('success', 'Venture successfully updated');
        return redirect()->route('venture.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venture  $venture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venture $venture)
    {
        $venture->delete();
        Session::flash('success', 'Venture successfully deleted.');

        return redirect()->back();
    }
}
