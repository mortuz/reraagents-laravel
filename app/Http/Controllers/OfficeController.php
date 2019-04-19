<?php

namespace App\Http\Controllers;

use Session;
use App\Office;
use App\State;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('office.index')->with('offices', Office::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('office.create')->with('states', State::all());
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
            'state' => 'required',
            'mobile' => 'nullable|max:10'
        ]);

        Office::create([
            'state_id' => $request->state,
            'city_id'  => $request->city,
            'mobile'   => $request->mobile,
            'address'  => $request->address,
            'url'      => $request->url,
            'map'      => $request->map,
            'govt'     => $request->govt ? $request->govt : 0,
        ]);

        Session::flash('success', 'Office successfully added.');

        return redirect()->route('office.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        return view('office.edit')
                    ->with('office', $office)
                    ->with('states', State::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        $this->validate($request, [
            'state' => 'required',
        ]);

        $office->state_id = $request->state;
        $office->city_id = $request->city;
        $office->mobile = $request->mobile;
        $office->address = $request->address;
        $office->url = $request->url;
        $office->map = $request->map;
        $office->govt = $request->govt ? $request->govt : 0;

        $office->save();

        Session::flash('success', 'Office successfully updated.');

        return redirect()->route('office.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->delete();
        Session::flash('success', 'Office successfully deleted.');
        return redirect()->back();
    }
}
