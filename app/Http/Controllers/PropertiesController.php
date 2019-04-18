<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\State;
use App\Property;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('properties.index')->with('properties', Property::latest()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('properties.create')
                        ->with('states', State::all());
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
            'city' => 'required|regex:/[1-9]/',
            'price' => 'required',
            'contact' => 'required|max:10',
            'handler' => 'required',
            'status' => 'required',
            'raw_price' => 'required',
            'raw_measurement' => 'required',
            'raw_location' => 'required',
            'raw_details' => 'required'
        ]);

        $property = Property::create([
            'state_id' => $request->state,
            'city_id' => $request->city,
            'handler' => $request->handler,
            'status' => $request->status,
            'mobile' => $request->contact,
            'user_id' => Auth::id(),
            'raw_data' => json_encode([
                'price' => $request->price,
                'measurement' => $request->measurement,
                'location' => $request->location,
                'details' => $request->details
            ]),
        ]);

        if ($request->bhk) {
            $property->rooms()->attach(explode(',', $request->bhk));
        }
        
        if ($request->face) {
            $property->faces()->attach(explode(',', $request->face));
        }

        if ($request->area) {
            $property->areas()->attach(explode(',', $request->area));
        }

        if ($request->landmark) {
            $property->landmarks()->attach(explode(',', $request->landmark));
        }

        if ($request->price) {
            $property->prices()->attach(explode(',', $request->price));
        }

        if ($request->type) {
            $property->propertytypes()->attach(explode(',', $request->type));
        }

        if ($request->builders) {
            $property->builders()->attach(explode(',', $request->builders));
        }

        if ($request->agents) {
            $property->agents()->attach(explode(',', $request->agents));
        }

        if ($request->ventures) {
            $property->ventures()->attach(explode(',', $request->ventures));
        }

        Session::flash('success', 'Property successfully added.');
        return redirect()->route('properties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $property->rooms = implode(',', $property->rooms()->pluck('b_h_k_s.id')->toArray());
        $property->area = implode(',', $property->areas()->pluck('areas.id')->toArray());
        $property->landmark = implode(',', $property->landmarks()->pluck('landmarks.id')->toArray());
        $property->face = implode(',', $property->faces()->pluck('faces.id')->toArray());
        $property->price = implode(',', $property->prices()->pluck('prices.id')->toArray());
        $property->type = implode(',', $property->propertytypes()->pluck('property_types.id')->toArray());

        $property->agents = implode(',', $property->agents()->pluck('agent_profiles.id')->toArray());
        $property->builders = implode(',', $property->builders()->pluck('builder_profiles.id')->toArray());
        $property->ventures = implode(',', $property->ventures()->pluck('ventures.id')->toArray());
        $property->raw = json_decode($property->raw_data, true);

        // dd($property);
        
        return view('properties.edit')
                        ->with('property', $property)
                        ->with('states', State::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $this->validate($request, [
            'state' => 'required',
            'city' => 'required|regex:/[1-9]/',
            'price' => 'required',
            'contact' => 'required|max:10',
            'handler' => 'required',
            'status' => 'required',
            'raw_price' => 'required',
            'raw_measurement' => 'required',
            'raw_location' => 'required',
            'raw_details' => 'required'
        ]);

        // dd($request->all());

        $property->state_id = $request->state;
        $property->city_id = $request->city;
        $property->handled_by = $request->handler;
        $property->status = $request->status;
        $property->mobile = $request->contact;

        $raw_data = json_encode([
                'price' => $request->raw_price,
                'measurement' => $request->raw_measurement,
                'location' => $request->raw_location,
                'details' => $request->raw_details
            ]);
        $property->raw_data = $raw_data;

        $property->save();


        if ($request->bhk) {
            $property->rooms()->sync(explode(',', $request->bhk));
        }
        
        if ($request->face) {
            $property->faces()->sync(explode(',', $request->face));
        }

        if ($request->area) {
            $property->areas()->sync(explode(',', $request->area));
        }

        if ($request->landmark) {
            $property->landmarks()->sync(explode(',', $request->landmark));
        }

        if ($request->price) {
            $property->prices()->sync(explode(',', $request->price));
        }

        if ($request->type) {
            $property->propertytypes()->sync(explode(',', $request->type));
        }

        if ($request->builders) {
            $property->builders()->sync(explode(',', $request->builders));
        }

        if ($request->agents) {
            $property->agents()->sync(explode(',', $request->agents));
        }

        if ($request->ventures) {
            $property->ventures()->sync(explode(',', $request->ventures));
        }

        // Space for notification

        Session::flash('success', 'Property successfully updated.');
        return redirect()->route('properties.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
