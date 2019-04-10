<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Face;

class FaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faces = Face::all()->transform(function ($face) {
            return [
                'name' => $face->face,
                'id'   => $face->id
            ];
        });
        return response()->json(['success' => true, 'data' => $faces]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function facesFromCity()
    {
        $city = request()->city;

        $ventures = Face::where('city_id', $city);
        
        foreach ($ventures as $venture) {
            $venture->source = $venture->name;
        }


        return response()->json(['success' => true, 'data' => Face::where('city_id', $city)->get()]);
    }
}
