<?php

namespace App\Http\Controllers;

use App\PropertyType;
use Illuminate\Http\Request;
use Session;

class PropertyTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('property-type.index')->with('types', PropertyType::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property-type.create');
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
            'type' => 'required'
        ]);

        PropertyType::create([
            'type' => $request->type,
            'slug' => str_slug($request->type)
        ]);

        Session::flash('success', 'Property type successfully created.');
        return redirect()->route('property-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyType $propertyType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyType $propertyType)
    {
        return view('property-type.edit')->with('type', $propertyType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyType $propertyType)
    {
        $this->validate($request, [
            'type' => 'required'
        ]);

        $propertyType->type = $request->type;
        $propertyType->slug = str_slug($request->type);
        $propertyType->save();

        Session::flash('success', 'Property type successfully updated');

        return redirect()->route('property-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyType $propertyType)
    {
        Session::flash('success', `{$propertyType->type} successfully deleted.`);
        $propertyType->delete();
        return redirect()->back();
    }
}
