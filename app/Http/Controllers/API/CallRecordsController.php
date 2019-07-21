<?php

namespace App\Http\Controllers\API;

use App\CallRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Designation;
use App\State;
use App\City;
use App\CallerComment;

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
        ]);

        $record = CallRecord::firstOrCreate(
            ['mobile' => $request->mobile],
            [
                'designation_id' => $request->designation_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'user_id' => $request->user()->id
            ]
        );

        if ($request->comment) {
            CallerComment::create([
                'user_id' => $request->user()->id,
                'call_record_id' => $record->id,
                'comment' => $request->comment
            ]);
        }

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
        if ($record) {
            $record->comments = $record->comments;
        }

        // if(!$record) {
        $data = [
            'states' => State::orderBy('name')->get(),
            'cities' =>City::where('state_id', $record ? $record->state_id : null)->orderBy('name')->get(),
            'designations' => Designation::orderBy('designation')->get()
        ];
        // }

        return response()->json(['success' => true, 'record' => $record, 'data' => $data]);
    }
}
