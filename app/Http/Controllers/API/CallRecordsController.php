<?php

namespace App\Http\Controllers\API;

use App\CallRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Designation;
use App\State;

class CallRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'mobile' => 'required',
            'designation_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'comment' => 'required'
        ]);

        CallRecord::updateOrCreate(
            ['mobile' => $request->mobile],
            [
                'designation_id' => $request->designation_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'comment' => $request->comment,
                'added_by' => $request->user()->id
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CallRecord  $callRecord
     * @return \Illuminate\Http\Response
     */
    public function show(CallRecord $callRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CallRecord  $callRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CallRecord $callRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CallRecord  $callRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(CallRecord $callRecord)
    {
        //
    }

    public function find(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required'
        ]);

        $record = CallRecord::where('mobile', $request->mobile)->first();

        $data = [
            'states' => [],
            'designations' => []
        ];

        // if(!$record) {
            $data = [
                'states' => State::all(),
                'designations' => Designation::all()
            ];
        // }

        return response()->json(['success' => true, 'record' => $record, 'data' => $data]);
    }
}
