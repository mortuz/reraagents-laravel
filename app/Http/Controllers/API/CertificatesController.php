<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Certificate;

class CertificatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = Certificate::all();

        $certificates->transform(function($certificate) {
            return [
                'id' => $certificate->id,
                'status' => $certificate->status,
                'state' => $certificate->state->name,
                'certificate_no' => $certificate->certificate_no,
                'expiry_date' => $certificate->expiry_date
            ];
        });

        return response()->json(['success' => true, 'data' => $certificates]);
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
            'certificate_no' => 'required|unique:certificates,certificate_no',
            'state_id' => 'required',
            'expiry_date' => 'required',
            'image' => 'required|image'
        ]);

        $image = $request->image;
        $image_new_name = time() . $image->getClientOriginalName();
        $image->move('uploads/certificates', $image_new_name);

        Certificate::create([
            'user_id'   => $request->user()->id,
            'certificate_no' => $request->certificate_no,
            'state_id'  => $request->state_id,
            'expiry_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $request->expiry_date)->format('Y-m-d'),
            'url'       => 'uploads/certificates/' . $image_new_name
        ]);


        return response()->json(['success' => true, 'message' => "We'll review your application and respond you back."]);
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
}
