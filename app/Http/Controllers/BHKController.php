<?php

namespace App\Http\Controllers;

use Session;
use App\BHK;
use Illuminate\Http\Request;

class BHKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bhk.index')->with('bhks', BHK::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bhk.create');
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

        BHK::create([
            'type' => $request->type,
            'slug' => str_slug($request->type)
        ]);

        Session::flash('success', 'New BHK type has been added');
        return redirect()->route('bhk.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BHK  $bhk
     * @return \Illuminate\Http\Response
     */
    public function show(BHK $bhk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BHK  $bhk
     * @return \Illuminate\Http\Response
     */
    public function edit(BHK $bhk)
    {
        return view('bhk.edit')->with('bhk', $bhk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BHK  $bhk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BHK $bhk)
    {
        $this->validate($request, [
            'type' => 'required'
        ]);

        $bhk->type = $request->type;
        $bhk->slug = str_slug($request->type);

        $bhk->save();

        Session::flash('success', 'BHK type successfully updated.');
        return redirect()->route('bhk.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BHK  $bhk
     * @return \Illuminate\Http\Response
     */
    public function destroy(BHK $bhk)
    {
        $bhk->delete();
        Session::flash('success', 'New BHK type has been added');
        return redirect()->back();
    }
}
