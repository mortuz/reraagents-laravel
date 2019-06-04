<?php

namespace App\Http\Controllers\API;

use App\Finance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finances = Finance::where('user_id', request()->user()->id)->get();

        $finances->transform(function($finance) {
            return [
                'id' => $finance->id,
                'name' => $finance->name,
                'contact' => $finance->contact,
                'description' => $finance->description,
                'state' => $finance->state->name,
                'city' => $finance->city->name,
                'purpose' => $finance->purpose->purpose,
                'created_at' => $finance->created_at
            ];
        });

        return response()->json(['success' => true, 'data' => $finances]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json(['success' => false, 'message' => 'Successfully submitted your request.', 'data' => $request->all()]);

        $this->validate($request, [
            'name' => 'required',
            'contact' => 'required',
            'state' => 'required',
            'city' => 'required',
            'purpose' => 'required',
            'description' => 'required'
        ]);

        Finance::create([
            'name'   => $request->name,
            'contact' => $request->contact,
            'loan_purpose_id'   => $request->purpose,
            'city_id'   => $request->city,
            'state_id'   => $request->state,
            'description' => $request->description,
            'user_id' => $request->user()->id
        ]);

        return response()->json(['success' => true, 'message' => 'Successfully submitted your request.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Finance $finance)
    {
        //
    }
}
