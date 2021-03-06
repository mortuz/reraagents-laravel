<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Office;
use App\State;
use Carbon\Carbon;
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
            'mobile' => 'nullable|max:10',
            'logo' => 'nullable|image'
        ]);


        $logo = '';

        if($request->logo) {
            $image = $request->logo;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/offices', $image_new_name);
            $logo = 'uploads/offices/' . $image_new_name;
        }

        Office::create([
            'name'     => $request->name,
            'state_id' => $request->state,
            'city_id'  => $request->city,
            'mobile'   => $request->mobile,
            'address'  => $request->address,
            'url'      => $request->url,
            'map'      => $request->map,
            'terms'    => $request->terms,
            'logo'     => $logo,
            'user_id'  => Auth::id(),
            'govt'     => $request->govt ? $request->govt : 0,
            'verified' => $request->verified ? $request->verified : 0,
            'verified_at' => $request->verified ? Carbon::now() : null,
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
            'logo' => 'nullable|image'
        ]);

        $logo = '';

        if ($request->logo) {
            $image = $request->logo;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/offices', $image_new_name);
            $logo = 'uploads/offices/' . $image_new_name;
            // remove old logo
            if ($office->logo) {
                unlink(public_path($office->logo));
            }
        }

        $office->name = $request->name;
        $office->state_id = $request->state;
        $office->city_id = $request->city;
        $office->mobile = $request->mobile;
        $office->address = $request->address;
        $office->url = $request->url;
        $office->terms = $request->terms;
        $office->map = $request->map;
        $office->logo = $logo;
        $office->govt = $request->govt ? $request->govt : 0;
        $office->verified = $request->verified ? $request->verified : 0;
        $office->verified_at = $request->verified ? Carbon::now() : null;

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
