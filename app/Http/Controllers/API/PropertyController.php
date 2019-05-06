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
use App\Office;
use App\Feedback;
use App\Transaction;

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

        $filter[] = ['state_id', $request->state];

        if ($request->city > 0) {
            $filter[] = ['city_id', $request->city];
        }

        $filter[] = ['status', 1];
        $filter[] = ['inactive', 0];

        if ($request->price) {
            $filter[] = ['price', $request->price];
        }

        $properties = Property::where($filter)
                                ->where('premium', 0)
                                ->latest()
                                ->get();
                                
        $premiumProperties = Property::where($filter)
                                ->where('premium', 1)
                                ->latest()
                                ->get();
                                
        $formattedProperties = [];

        $properties->transform(function ($property) {
            return [
                'id'            => $property->id,
                'state'         => $property->state->name,
                'state_id'      => $property->state_id,
                'city_id'       => $property->city_id,
                'city'          => $property->city->name,
                'features'      => $property->features,
                'premium'       => $property->premium,
                'property_type' => $property->propertytypes->first()->type,
                'area'          => count($property->areas) == 0 ? null : $property->areas->first()->area,
                'measurement'   => json_decode($property->raw_data)->measurement,
                'price'         => $property->prices->first()->price,
                'heading'       => json_decode($property->raw_data)->details,
                'raw'           => json_decode($property->raw_data),
                'features'      => $property->features,
                'created_at'    => $property->created_at,
                'updated_at'    => $property->updated_at,
                'expiry_date'   => $property->expiry_date,
            ];
        });

        $premiumProperties->transform(function ($property) {
            return [
                'id'            => $property->id,
                'state'         => $property->state->name,
                'state_id'      => $property->state_id,
                'city_id'       => $property->city_id,
                'city'          => $property->city->name,
                'features'      => $property->features,
                'premium'       => $property->premium,
                'property_type' => $property->propertytypes->first()->type,
                'area'          => count($property->areas) == 0 ? null : $property->areas->first()->area,
                'measurement'   => json_decode($property->raw_data)->measurement,
                'price'         => $property->prices->first()->price,
                'heading'       => json_decode($property->raw_data)->details,
                'raw'           => json_decode($property->raw_data),
                'images'        => json_decode($property->images),
                'google_map'    => $property->google_map,
                'youtube_link'  => $property->youtube_link,
                'website'       => $property->website,
                'features'      => $property->features,
                'created_at'    => $property->created_at,
                'updated_at'    => $property->updated_at,
                'expiry_date'   => $property->expiry_date,
            ];
        });

        $index = 2;
        $featuredIndex = 0;

        foreach ($properties as $property) {

            // if ($index > 1 && $index % 3 == 0) {
            if ($premiumProperties->count() > $featuredIndex) {
                array_push($formattedProperties, $premiumProperties[$featuredIndex]);
            }
            $featuredIndex++;
            // }

            array_push($formattedProperties, $property);
            $index++;
        }

        

        return response()->json(['success' => true, 'data' => $formattedProperties]);
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

        $users = User::where('mobile', $request->mobile)->where('mobile_verified_at', '!=', null)->get();
        $properties = Property::where('mobile', $request->mobile)->get();
        
        if ($users->count() || $properties->count()) {
            $property = $this->modify($property, $request);

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
                    $property = $this->modify($property, $request);

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


        return response()->json(['success' => false, 'message' => 'Testing route', 'property' => $property]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        if ($property->user_id != request()->user()->id) {
            return response()->json(['success' => false, 'message' => 'You do not own this property.']);
        }

        $property->inactive = 1;
        $property->save();

        return response()->json(['success' => true, 'message' => 'Property successfully deleted.']);
    }

    public function my()
    {
        $properties = Property::where('user_id', request()->user()->id)->where('inactive', 0)->get();

        $properties->transform(function ($property) {
            $feedback = Feedback::where('property_id', $property->id)->first();
            return [
                'id'            => $property->id,
                'state'         => $property->state->name,
                'state_id'      => $property->state_id,
                'city_id'       => $property->city_id,
                'city'          => $property->city->name,
                'type'          => $property->propertytypes->first()->id,
                'features'      => $property->features,
                'premium'       => $property->premium,
                'property_type' => $property->propertytypes->first()->type,
                'created_at'    => $property->created_at,
                'premium'       => $property->premium,
                'status'        => $property->status,
                'mobile'        => $property->mobile,
                'expiry_date'   => $property->expiry_date,
                'area'          => count($property->areas) == 0 ? json_decode($property->raw_data)->location : $property->areas->first()->area,
                'measurement'   => json_decode($property->raw_data)->measurement,
                'price'         => $property->prices->first() ? $property->prices->first()->price : json_decode($property->raw_data)->price,
                'landmark'      => $property->landmarks->first() ? $property->landmarks->first()->name : null,
                'heading'       => json_decode($property->raw_data)->details,
                'message'       => $feedback ? $feedback->message : null
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

        $property->propertytypes()->attach(explode(',', $request->type));
        $property->agents()->attach(explode(',', $request->user()->id));

        return $property;
    }

    public function modify($property, $request)
    {
        $raw = json_encode([
                'price' => $request->price,
                'measurement' => $request->measurement,
                'location' => $request->location,
                'details' => $request->details
            ]);

        $property->state_id = $request->state;
        $property->city_id = $request->city;
        $property->mobile = $request->mobile;
        $property->raw_data = $raw;
        $property->status = 0;
        
        $property->save();
        $property->propertytypes()->sync(explode(',', $request->type));

        return $property;
    }

    public function view()
    {
        $request = request();
        
        $propertyId = $request->property;

        $property = Property::find($propertyId);

        $certificates = $request->user()->certificates()
                            ->where('status', 1)
                            ->where('state_id', $property->state_id)
                            ->get();

        // if no certificate found
        if (!$certificates->count()) {
            return response()->json(['success' => false, 'permission' => false]);
        }

        Transaction::updateOrCreate([
            'user_id' => $request->user()->id,
            'property_id' => $propertyId
        ], []);

        // if handled by company i.e., handled_by = 1
        if ($property->handled_by) {
            $office = Office::where('city_id', $property->city_id)->first();
            // return city office no.
            return response()->json(['success' => true, 'data' => $office->mobile]);
        }

        // return property no
        return response()->json(['success' => true, 'data' => $property->mobile]);
    }

    public function office()
    {
        $request = request();
        $propertyId = $request->property;
        $property = Property::find($propertyId);
        
        if (!$property) {
            return response()->json(['success' => false, 'errors' => true, 'message' => 'Property not available.']);
        }
        // fetch regional office in the city
        $regionalOffice = Office::where('city_id', $property->city_id)->where('govt', 0)->first();

        // fetch govt office in the state
        $govtOffice = Office::where('state_id', $property->state_id)->where('govt', 1)->first();

        $additional = [
          'state' => $property->state->name,
          'state_id' => $property->state_id,
          'city' => $property->city->name,
          'city_id' => $property->city_id,
        ];

        $data = [
            'govt'       => $govtOffice,
            'regional'   => $regionalOffice,
            'additional' => $additional
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function premiumCall(Request $request)
    {
        $propertyId = $request->property;

        $property = Property::find($propertyId);

        Transaction::updateOrCreate([
            'user_id' => $request->user()->id,
            'property_id' => $propertyId
        ], []);


        // if handled by company i.e., handled_by = 1
        if ($property->handled_by) {
            $office = Office::where('city_id', $property->city_id)->first();
            // return city office no.
            return response()->json(['success' => true, 'data' => $office->mobile]);
        }

        // return property no
        return response()->json(['success' => true, 'data' => $property->mobile]);
    }

    public function premiumDetail(Request $request)
    {
        $propertyId = $request->property;
        
        $property = Property::find($propertyId);

        $property->state = $property->state->name;
        $property->state_id      = $property->state_id;
        $property->city_id       = $property->city_id;
        $property->city          = $property->city->name;
        $property->property_type = $property->propertytypes->first()->type;
        $property->area          = count($property->areas) == 0 ? null : $property->areas->first()->area;
        $property->measurement   = json_decode($property->raw_data)->measurement;
        $property->price         = $property->prices->first()->price;
        $property->heading       = json_decode($property->raw_data)->details;
        $property->raw           = json_decode($property->raw_data);
        $property->images        = json_decode($property->images);

        return response()->json(['success' => true, 'data' => $property]);
    }

    public function postGuestProperty(Request $request)
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

        $signer = new HS256(env('JWT_KEY'));
        if ($request->token) {
            $parser = new JwtParser($signer);
            $claims = $parser->parse($request->token);

            if ($request->otp != $claims['code']) {
                return response()->json(['success' => false, 'errors' => true, 'message' => 'Invalid OTP']);
            } else {
                // create property

                $user = User::where('mobile', $request->mobile)->where('mobile_verified_at', '!=', null)->first();

                $property = Property::create([
                    'state_id' => $request->state,
                    'city_id'  => $request->city,
                    'user_id'  => $user ? $user->id : 0,
                    'mobile'   => $request->mobile,
                    'raw_data' => json_encode([
                        'price' => $request->price,
                        'measurement' => $request->measurement,
                        'location' => $request->location,
                        'details' => $request->details
                    ]),
                ]);

                $property->propertytypes()->attach($request->type);

                if ($user) {
                    $property->agents()->attach($user->id);
                }

                return response()->json(['success' => true, 'data' => $property]);
            }
        } else {
            $generator = new JwtGenerator($signer);
            $code = substr(str_shuffle("0123456789"), 0, 6);
            $jwt = $generator->generate(['code' => $code]);

            $smsHelper = new SmsHelper();
            
            $smsHelper->sendOTP($request->mobile, $code);
            
            return response()->json(['success' => false, 'otp_required' => true, 'token' => $jwt]);
        }
    }
}
