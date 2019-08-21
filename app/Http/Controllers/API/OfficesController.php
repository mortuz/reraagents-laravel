<?php

namespace App\Http\Controllers\API;

use App\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offices = Office::where('user_id', request()->user()->id)->get();

        $offices->transform(function($office) {
            return [
                'id' => $office->id,
                'name' => $office->name,
                'state' => $office->state->name,
                'city' => $office->city->name,
                'mobile' => $office->mobile,
                'website' => $office->website,
                'address' => $office->address,
                'coordinates' => $office->coordinates,
                'verified' => $office->verified,
                'verified_at' => $office->verified_at,
            ];
        });
        return response()->json(['success' => true, 'data' => $offices]);
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
            'city'  => 'required',
            'address' => 'required',
            'coordinates' => 'required',
            // 'mobile' => ['required', 'mobile', Rule::unique('users', 'mobile')->ignore($request->user()->id)],
            'mobile' => 'required',
            'name' => 'required'
        ]);

        Office::create([
            'state_id' => $request->state,
            'city_id' => $request->city,
            'address' => $request->address ? $request->address : 0,
            'coordinates' => $request->coordinates,
            'website' => $request->website,
            'user_id' => $request->user()->id,
            'mobile' => $request->mobile,
            'name'  => $request->name
        ]);

        return response()->json(['success' => true, 'message' => 'Office successfully created.']);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }

    public function fetchOffice(Request $request)
    {
        $city = $request->city;

        $offices = Office::where('city_id', $city)->where('govt', 0)->get();

        $offices->transform(function($office) {
            return [
                'id' => $office->id,
                'name' => $office->name,
                'state' => $office->state->name,
                'city' => $office->city->name,
                'address' => $office->address,
                'mobile' => $office->mobile,
                'verified' => $office->verified
            ];
        });

        return response()->json(['success' => true, 'data' => $offices]);
    }
}
