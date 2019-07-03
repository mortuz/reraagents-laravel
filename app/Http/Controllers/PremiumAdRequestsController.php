<?php

namespace App\Http\Controllers;

use App\PremiumAdRequest;
use Illuminate\Http\Request;

class PremiumAdRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('premium.request.index')->with('requests', PremiumAdRequest::latest()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\PremiumAdRequest  $premiumAdRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(PremiumAdRequest $premiumAdRequest)
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
