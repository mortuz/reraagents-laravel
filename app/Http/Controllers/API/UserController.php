<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Property;
use App\Certificate;
use App\AgentProfile;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $agent = AgentProfile::where('user_id', $request->user()->id)->first();
        $data = [];
        $data['user']['name'] = $request->user()->name;
        $data['user']['email'] = $request->user()->email;
        $data['user']['mobile'] = $request->user()->mobile;

        $certificates = $request->user()->certificates()->where('status', 1)->get();

        $certificates->transform(function ($certificate) {
            return $certificate->state_id;
        });

        $ads = [];
        $ad = null;
        // look for city ads
        $ad = Advertisement::where('city_id', $request->user()->city_id)->latest()->first();
        
        // look for state ads
        if (!$ad) {
            $ad = Advertisement::where('state_id', $request->user()->state_id)->where('city_id', null)->latest()->first();
        }

        // look for any ads
        if (!$ad) {
            $ad = Advertisement::first();
        }

        if (!$ad) {
            $ads = [];
        } else {
            $ads[] = $ad;
        }


        $data['user']['state'] = $agent->state_id;
        $data['user']['city'] = $agent->city_id;

        $data['user']['permissions'] = $certificates;


        $data['property']['my'] = Property::where('user_id', $request->user()->id)->get()->count();

        $data['app_url'] = 'https://play.google.com/store/apps/details?id=in.idevia.reraagents';
        $data['version'] = '0.8';
        $data['ads'] = $ads;

        return response()->json(['success' => true, 'data' => $data]);
    }
}
