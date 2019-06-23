<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Venture;

class VentureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventures = Venture::where('city_id', request()->city)->get()->transform(function ($venture) {
            return [
                'name' => $venture->name,
                'id'   => $venture->id
            ];
        });
        return response()->json(['success' => true, 'data' => $ventures]);
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

        return response()->json(['success' => true, 'message' => 'Venture created successfully']);
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

    public function venturesFromCity()
    {
        $city = request()->city;

        $ventures = Venture::where('city_id', $city);
        
        foreach ($ventures as $venture) {
            $venture->source = $venture->name;
        }


        return response()->json(['success' => true, 'data' => Venture::where('city_id', $city)->get()]);
    }
}
