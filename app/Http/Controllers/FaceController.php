<?php

namespace App\Http\Controllers;

use App\Face;
use Session;
use Illuminate\Http\Request;

class FaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('face.index')->with('faces', Face::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('face.create');
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
            'face' => 'required'
        ]);

        Face::create([
            'face' => $request->face,
            'slug' => str_slug($request->face)
        ]);

        Session::flash('success', 'Property facing successfully created.');
        return redirect()->route('face.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Face  $face
     * @return \Illuminate\Http\Response
     */
    public function show(Face $face)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Face  $face
     * @return \Illuminate\Http\Response
     */
    public function edit(Face $face)
    {
        return view('face.edit')->with('face', $face);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Face  $face
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Face $face)
    {
        $this->validate($request, [
            'face' => 'required'
        ]);

        $face->face = $request->face;
        $face->slug = str_slug($request->face);
        $face->save();

        Session::flash('success', 'Property facing successfully updated.');
        return redirect()->route('face.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Face  $face
     * @return \Illuminate\Http\Response
     */
    public function destroy(Face $face)
    {
        $face->delete();
        Session::flash('success', 'Property facing successfully deleted.');
        return redirect()->back();
    }
}
