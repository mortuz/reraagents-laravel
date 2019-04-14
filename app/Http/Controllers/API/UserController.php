<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AgentProfile;
use App\Property;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $agent = AgentProfile::where('user_id', $request->user()->id)->first();
        $data = [];
        $data['user']['name'] = $request->user()->name;
        $data['user']['email'] = $request->user()->email;
        $data['user']['mobile'] = $request->user()->mobile;


        $data['user']['state'] = $agent->state_id;
        $data['user']['city'] = $agent->city_id;

        $data['property']['my'] = Property::where('user_id', $request->user()->id)->get()->count();

        $data['version'] = '0.5';
        $data['ads'] = [];

        return response()->json(['success' => true, 'data' => $data]);
    }
}
