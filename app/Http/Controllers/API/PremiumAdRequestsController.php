<?php

namespace App\Http\Controllers\API;

use App\PremiumAdRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PremiumAdRequestsController extends Controller
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
        $this->validate($request,[
            'interest' => 'required'
        ]);

        $check = PremiumAdRequest::where('user_id', $request->user()->id)
                                    ->where('paid', 0)
                                    ->first();

        if($check) {
            return response()->json(['success' => false, 'message' => 'You already requested for premium ads']);
        }

        PremiumAdRequest::create([
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Our agent will be in touch with you shortly.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PremiumAdRequest  $premiumAdRequest
     * @return \Illuminate\Http\Response
     */
    public function show(PremiumAdRequest $premiumAdRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PremiumAdRequest  $premiumAdRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PremiumAdRequest $premiumAdRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PremiumAdRequest  $premiumAdRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(PremiumAdRequest $premiumAdRequest)
    {
        //
    }
}
