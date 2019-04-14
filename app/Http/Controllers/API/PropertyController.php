<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MiladRahimi\Jwt\JwtParser;
use MiladRahimi\Jwt\JwtGenerator;
use App\Http\Controllers\Controller;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use App\Helpers\SmsHelper;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'state' => 'required'
        ]);

        $filter = [];
        $city = 0;

        // $filter[] = ['state', $request->getParam('state')];

        if ($request->city> 0) {
            $filter[] = ['city', $city];
        }

        $filter[] = ['status', 1];

        if ($request->price) {
            $filter[] = ['price', $request->price];
        }

        $properties = Property::where($filter)
                                ->where('premium', 0)
                                ->latest()
                                ->get();

        return response()->json(['success' => true, 'data' => $properties]);
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
            'state' => 'required',
            'city' => 'required',
            'type' => 'required',
            'mobile' => 'required',
            'price' => 'required',
            'measurement' => 'required',
            'location' => 'required',
            'details' => 'required'
        ]);

        // verify mobile no
        $users = User::where('mobile', $request->mobile)->where('mobile_verified_at', '!=', null)->get();
        $properties = Property::where('mobile', $request->mobile)->get();

        if ($users->count() || $properties->count()) {
            $property = $this->create($request);

            return response()->json(['success' => true, 'data' => $property]);
        } else {
            // generate OTP and token
            $signer = new HS256(env('JWT_KEY'));
            if ($request->token) {
                $parser = new JwtParser($signer);
                $claims = $parser->parse($request->token);

                if ($request->otp != $claims['code']) {
                    return response()->json(['success' => false, 'errors' => true, 'message' => 'Invalid OTP']);
                } else {
                    // create property
                    $property = $this->create($request);

                    if ($request->user()->mobile == $request->mobile) {
                        $user = User::find($request->user()->id);
                        $user->mobile_verified_at = Carbon::now();
                        $user->save();
                    }
                    
                    return response()->json(['success' => true, 'data' => $property]);
                }
            } else {
                $generator = new JwtGenerator($signer);
                $code = substr(str_shuffle("0123456789"), 0, 6);
                $jwt = $generator->generate(['code' => $code]);

                $smsHelper = new SmsHelper();
                
                $smsHelper->sendOTP($request->mobile, $code);
                
                return response()->json(['success' => false, 'otp_required' => true, 'token' => $jwt, 'code' => $code]);
            }
        }
        // if !verified generate otp and token
        // else create property
        // return $property
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }

    public function my()
    {
        $properties = Property::where('user_id', request()->user()->id)->get();

        $properties->transform(function($property) {
            return [
                'id' => $property->id,
                'state' => $property->state->name,
                'city'  => $property->city->name,
                'created_at' => $property->created_at,
                'premium' => $property->premium,
                'status' => $property->status
            ];
        });

        return response()->json(['success' => true, 'data' => $properties]);
    }

    public function create($request)
    {
        // return response()->json($request);
        $property = Property::create([
            'state_id' => $request->state,
            'city_id'  => $request->city,
            'user_id'  => $request->user()->id,
            'mobile'   => $request->mobile,
            'raw_data' => json_encode([
                'price' => $request->price,
                'measurement' => $request->measurement,
                'location' => $request->location,
                'details' => $request->details
            ]),
        ]);

        return $property;
    }
}
