<?php

namespace App\Http\Controllers\API;

use App\LoanPurpose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanPurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purposes = LoanPurpose::all();

        return response()->json(['success' => true, 'data' => $purposes]);
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
     * @param  \App\LoanPurpose  $loanPurpose
     * @return \Illuminate\Http\Response
     */
    public function show(LoanPurpose $loanPurpose)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoanPurpose  $loanPurpose
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanPurpose $loanPurpose)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LoanPurpose  $loanPurpose
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanPurpose $loanPurpose)
    {
        //
    }
}
