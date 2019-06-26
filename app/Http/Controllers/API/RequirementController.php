<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Office;
use App\AgentProfile;
use App\Property;
use App\Requirement;
use App\CustomerStatus;
use App\RequirementTransaction;
use App\RequirementStatusTransaction;
use MiladRahimi\Jwt\JwtParser;
use MiladRahimi\Jwt\JwtGenerator;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use Illuminate\Http\Request;
use App\Helpers\SmsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequirementStatusChangeNotification;
use App\Notifications\PremiumPropertyNotification;

class RequirementController extends Controller
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

        $items_per_page = 20;
        $page = $request->page ? ((int)$request->page) : 1;

        $filter = [];

        $filter[] = ['state_id', $request->state];

        if ($request->city) {
            $filter[] = ['city_id', $request->city];
        }

        $filter[] = ['request_delete', 0];
        $filter[] = ['status', 1];
        $filter[] = ['inactive', 0];

        $requirements = Requirement::where($filter)
            ->where('working_agent', 0)
            ->limit($items_per_page)
            ->offset(($page - 1) * $items_per_page)
            ->latest()
            ->get();

        $requirements->transform(function ($requirement) {
            return [
                'id'            => $requirement->id,
                'raw'           => json_decode($requirement->raw_data),
                'city'          => $requirement->city->name,
                'area'          => count($requirement->areas) == 0 ? null : $requirement->areas->first()->area,
                'state'         => $requirement->state->name,
                'budget'        => count($requirement->prices) ? $requirement->prices->first()->price : '--',
                'heading'       => json_decode($requirement->raw_data)->details,
                'city_id'       => $requirement->city_id,
                'state_id'      => $requirement->state_id,
                'comments'      => $requirement->comments,
                'landmark'      => count($requirement->landmarks) == 0 ? null : $requirement->landmarks->first()->name,
                'features'      => $requirement->features,
                'created_at'    => $requirement->created_at,
                'updated_at'    => $requirement->updated_at,
                'property_type' => $requirement->propertytypes->first() ? $requirement->propertytypes->first()->type : null,
            ];
        });

        return response()->json(['success' => true, 'data' => $requirements]);
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
            'mobile' => 'required',
            'budget' => 'required',
            'details' => 'required'
        ]);

        // verify mobile no
        $users = User::where('mobile', $request->mobile)->where('mobile_verified_at', '!=', null)->get();
        $properties = Property::where('mobile', $request->mobile)->get();
        $requirement = Requirement::where('mobile', $request->mobile)->get();

        if ($users->count() || $properties->count() || $requirement->count()) {
            $requirement = $this->create($request);

            return response()->json(['success' => true, 'data' => $requirement]);
        } else {
            // generate OTP and token
            $signer = new HS256(env('JWT_KEY'));
            if ($request->token) {
                $parser = new JwtParser($signer);
                $claims = $parser->parse($request->token);

                if ($request->otp != $claims['code']) {
                    return response()->json(['success' => false, 'errors' => true, 'message' => 'Invalid OTP']);
                } else {
                    // create requirement
                    $requirement = $this->create($request);

                    if ($request->user()->mobile == $request->mobile) {
                        $user = User::find($request->user()->id);
                        $user->mobile_verified_at = Carbon::now();
                        $user->save();
                    }

                    return response()->json(['success' => true, 'data' => $requirement]);
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
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $request = request();
        $requirementId = $request->requirement;

        $requirement = Requirement::find($requirementId);

        if ($requirement->working_agent != $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'You are not currently working on this requirement.']);
        }

        $requirement->raw_data = json_decode($requirement->raw_data);

        $status = CustomerStatus::all();

        $data = [
            'requirement' => $requirement,
            'status' => $status
        ];
        return response()->json(['success' => true, 'data' => $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requirement $requirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $requirementId = $request->requirement;
        $requirement = Requirement::find($requirementId);

        if($request->user()->id != $requirement->user_id) {
            return response()->json(['success' => false, 'message' => 'You are not the owner of this account.']);
        }

        $requirement->request_delete = 1;
        $requirement->save();

        return response()->json(['success' => true, 'message' => 'You have successfully request deletion.']);
    }

    public function create($request)
    {
        $requirement = Requirement::create([
            'state_id' => $request->state,
            'city_id'  => $request->city,
            'user_id'  => $request->user()->id,
            'mobile'   => $request->mobile,
            'raw_data' => json_encode([
                'budget' => $request->budget,
                'details' => $request->details
            ]),
        ]);

        $requirement->agents()->attach(explode(',', $request->user()->id));

        return $requirement;
    }

    public function working(Request $request)
    {
        // $this->validate($request, [
        //     'state' => 'required'
        // ]);

        $filter = [];

        // $filter[] = ['state_id', $request->state];

        // if ($request->city) {
        //     $filter[] = ['city_id', $request->city];
        // }

        $filter[] = ['status', 1];
        $filter[] = ['inactive', 0];

        $requirements = Requirement::where($filter)
            ->where('working_agent', $request->user()->id)
            ->latest()
            ->get();

        $requirements->transform(function ($requirement) {
            return [
                'id'            => $requirement->id,
                'state'         => $requirement->state->name,
                'state_id'      => $requirement->state_id,
                'city_id'       => $requirement->city_id,
                'city'          => $requirement->city->name,
                'call_date'     => $requirement->call_date,
                'visit_date'    => $requirement->visit_date,
                'comments'      => $requirement->comments,
                'property_type' => $requirement->propertytypes->first() ? $requirement->propertytypes->first()->type : null,
                'area'          => count($requirement->areas) == 0 ? null : $requirement->areas->first()->area,
                'budget'        => count($requirement->prices) ? $requirement->prices->first()->price : '--',
                'heading'       => json_decode($requirement->raw_data)->details,
                'landmark'      => count($requirement->landmarks) == 0 ? null : $requirement->landmarks->first()->name,
                'raw'           => json_decode($requirement->raw_data),
                'features'      => $requirement->features,
                'created_at'    => $requirement->created_at,
                'updated_at'    => $requirement->updated_at,
            ];
        });

        return response()->json(['success' => true, 'data' => $requirements]);
    }

    public function my(Request $request)
    {
        // $this->validate($request, [
        //     'state' => 'required'
        // ]);

        $filter = [];

        // $filter[] = ['state_id', $request->state];

        // if ($request->city) {
        //     $filter[] = ['city_id', $request->city];
        // }

        // $filter[] = ['status', 1];
        $filter[] = ['inactive', 0];

        $requirements = Requirement::where($filter)
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        $requirements->transform(function ($requirement) {
            return [
                'id'            => $requirement->id,
                'raw'           => json_decode($requirement->raw_data),
                'city'          => $requirement->city->name,
                'area'          => count($requirement->areas) == 0 ? null : $requirement->areas->first()->area,
                'state'         => $requirement->state->name,
                'status'        => $requirement->status,
                'call_date'     => $requirement->call_date,
                'visit_date'    => $requirement->visit_date,
                'budget'        => count($requirement->prices) ? $requirement->prices->first()->price : json_decode($requirement->raw_data)->budget,
                'heading'       => json_decode($requirement->raw_data)->details,
                'city_id'       => $requirement->city_id,
                'state_id'      => $requirement->state_id,
                'comments'      => $requirement->comments,
                'landmark'      => count($requirement->landmarks) == 0 ? null : $requirement->landmarks->first()->name,
                'features'      => $requirement->features,
                'created_at'    => $requirement->created_at,
                'updated_at'    => $requirement->updated_at,
                'working_agent' => $requirement->working_agent,
                'request_delete' => $requirement->request_delete,
                'property_type' => $requirement->propertytypes->first() ? $requirement->propertytypes->first()->type : null,
            ];
        });

        return response()->json(['success' => true, 'data' => $requirements]);
    }

    public function view()
    {
        $request = request();

        $requirementId = $request->requirement;

        $requirement = Requirement::find($requirementId);

        if ($requirement->working_agent != 0) {
            return response()->json(['success' => false, 'message' => "Requirement is already taken over by some other agent"]);;
        }

        $certificates = $request->user()->certificates()
            ->where('status', 1)
            ->where('state_id', $requirement->state_id)
            ->get();

        // if no certificate found
        if (!$certificates->count()) {
            return response()->json(['success' => false, 'permission' => false]);
        }

        $requirement->working_agent = $request->user()->id;
        $requirement->save();

        // Transaction::updateOrCreate([
        //     'user_id' => $request->user()->id,
        //     'property_id' => $propertyId
        // ], []);

        RequirementTransaction::create([
            'requirement_id' => $requirement->id,
            'user_id' => $request->user()->id,
        ]);
        // if status approved status == 2

        if($requirement->status == 2) {
            $office = Office::where('city_id', $requirement->city_id)->first();
            // return city office no.
            return response()->json(['success' => true, 'data' => $office->mobile]);
        } else {
            // if handled by company i.e., handled_by = 1
            if ($requirement->handled_by) {
                $office = Office::where('city_id', $requirement->city_id)->first();
                // return city office no.
                return response()->json(['success' => true, 'data' => $office->mobile]);
            }
            // return property no
            return response()->json(['success' => true, 'data' => $requirement->mobile]);
        }
    }

    public function call()
    {
        $request = request();

        $requirementId = $request->requirement;

        $requirement = Requirement::find($requirementId);

        if ($requirement->working_agent != $request->user()->id) {
            return response()->json(['success' => false, 'message' => "You are not working on this requirement."]);;
        }

        $certificates = $request->user()->certificates()
            ->where('status', 1)
            ->where('state_id', $requirement->state_id)
            ->get();

        // if no certificate found
        if (!$certificates->count()) {
            return response()->json(['success' => false, 'permission' => false]);
        }

        $requirement->working_agent = $request->user()->id;
        $requirement->save();

        // Transaction::updateOrCreate([
        //     'user_id' => $request->user()->id,
        //     'property_id' => $propertyId
        // ], []);

        RequirementTransaction::create([
            'requirement_id' => $requirement->id,
            'user_id' => $request->user()->id,
        ]);
        // if status approved status == 2

        if ($requirement->status == 2) {
            $office = Office::where('city_id', $requirement->city_id)->first();
            // return city office no.
            return response()->json(['success' => true, 'data' => $office->mobile]);
        } else {
            // if handled by company i.e., handled_by = 1
            if ($requirement->handled_by) {
                $office = Office::where('city_id', $requirement->city_id)->first();
                // return city office no.
                return response()->json(['success' => true, 'data' => $office->mobile]);
            }
            // return property no
            return response()->json(['success' => true, 'data' => $requirement->mobile]);
        }
    }

    public function office()
    {
        $request = request();
        $requirementId = $request->requirement;
        $requirement = Requirement::find($requirementId);

        if (!$requirement) {
            return response()->json(['success' => false, 'errors' => true, 'message' => 'Requirement not available.']);
        }
        // fetch regional office in the city
        $regionalOffice = Office::where('city_id', $requirement->city_id)->where('govt', 0)->first();

        // fetch govt office in the state
        $govtOffice = Office::where('state_id', $requirement->state_id)->where('govt', 1)->first();

        $additional = [
            'state' => $requirement->state->name,
            'state_id' => $requirement->state_id,
            'city' => $requirement->city->name,
            'city_id' => $requirement->city_id,
        ];

        $data = [
            'govt'       => $govtOffice,
            'regional'   => $regionalOffice,
            'additional' => $additional
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function release(Request $request)
    {
        $requirementId = $request->requirement;
        $requirement = Requirement::find($requirementId);

        if ($requirement->working_agent != $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'You are not working on this requirement.']);
        }

        // create transaction
        // send notification to the owner
        $requirement->working_agent = 0;
        $requirement->customer_status_id = null;
        $requirement->visit_date = null;
        $requirement->call_date = null;
        $requirement->save();

        $agents = AgentProfile::where('city_id', $requirement->city_id)->get();
        $users = [];

        foreach ($agents as $agent) {
            if ($requirement->user_id == $agent->user_id || $request->user()->id == $agent->user_id) continue;
            array_push($users, $agent->user);
        }
        Notification::send($users, new PremiumPropertyNotification($requirement));

        return response()->json(['success' => true, 'message' => 'Requirement successfully released.']);
    }

    public function updateDetails(Request $request)
    {
        $this->validate($request, [
            'requirement' => 'required'
        ]);

        
        $requirementId = $request->requirement;
        
        $requirement = Requirement::find($requirementId);
        // return response()->json(['success' => true, 'params' => $requirement->status]);

        if($request->visit_date) {
            $requirement->visit_date = $request->visit_date;
        }

        if($request->call_date) {
            $requirement->call_date = $request->call_date;
        }

        $currentStatus = $requirement->customer_status_id;
        $requirement->customer_status_id = $request->status;
        $requirement->save();

        if($currentStatus != $request->status) {
            // send notification
            Notification::send($requirement->user, new RequirementStatusChangeNotification($requirement));
            // create transaction
            RequirementStatusTransaction::create([
                'customer_status_id' => $request->status,
                'requirement_id'     => $requirement->id,
                'user_id'           => $request->user()->id
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Details successfully updated.']);
    }

    public function callworkingAgent(Request $request)
    {
        $requirementId = $request->requirement;

        $requirement = Requirement::find($requirementId);

        if ($requirement->working_agent == 0) {
            return response()->json(['success' => false, 'message' => "No agent is working on this requirement."]);;
        }

        // $certificates = $request->user()->certificates()
        //     ->where('status', 1)
        //     ->where('state_id', $requirement->state_id)
        //     ->get();

        // if no certificate found
        // if (!$certificates->count()) {
        //     return response()->json(['success' => false, 'permission' => false]);
        // }

        // $requirement->working_agent = $request->user()->id;
        // $requirement->save();

        // if status approved status == 2

        if ($requirement->status == 2) {
            $office = Office::where('city_id', $requirement->city_id)->first();
            // return city office no.
            return response()->json(['success' => true, 'data' => $office->mobile]);
        } else {
            // if handled by company i.e., handled_by = 1
            if ($requirement->handled_by) {
                $office = Office::where('city_id', $requirement->city_id)->first();
                // return city office no.
                return response()->json(['success' => true, 'data' => $office->mobile]);
            }
            // return property no
            return response()->json(['success' => true, 'data' => $requirement->user->mobile]);
        }
    }

    public function postGuestRequirement(Request $request)
    {
        $this->validate($request, [
            'state' => 'required',
            'city' => 'required',
            'mobile' => 'required',
            'price' => 'required',
            'requirement' => 'required'
        ]);

        $signer = new HS256(env('JWT_KEY'));
        if ($request->token) {
            $parser = new JwtParser($signer);
            $claims = $parser->parse($request->token);

            if ($request->otp != $claims['code']) {
                return response()->json(['success' => false, 'errors' => true, 'message' => 'Invalid OTP']);
            } else {
                // create property

                $user = User::where('mobile', $request->mobile)->first();

                $requirement = Requirement::create([
                    'state_id' => $request->state,
                    'city_id'  => $request->city,
                    'user_id'  => $user ? $user->id : 0,
                    'mobile'   => $request->mobile,
                    'raw_data' => json_encode([
                        'budget' => $request->price,
                        'details' => $request->requirement
                    ]),
                ]);

                // $requirement->propertytypes()->attach(explode(',', $request->type));

                if ($user) {
                    $requirement->agents()->attach(explode(',', AgentProfile::where('user_id', $request->user()->id)->first()->id));
                }

                return response()->json(['success' => true, 'data' => $requirement]);
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
