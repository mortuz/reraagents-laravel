<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Property;
use App\Certificate;
use App\AgentProfile;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function user(Request $request)
    {
        $agent = AgentProfile::where('user_id', $request->user()->id)->first();
        $data = [];
        $data['user']['avatar'] = $request->user()->avatar;
        $data['user']['name'] = $request->user()->name;
        $data['user']['email'] = $request->user()->email;
        $data['user']['mobile'] = $request->user()->mobile;

        $certificates = $request->user()->certificates()->where('status', 1)->get();

        $certificates->transform(function ($certificate) {
            return $certificate->state_id;
        });

        $ads = [];
        $ad = null;
        $agent = AgentProfile::where('user_id', $request->user()->id)->first();
        // look for city ads
        $ad = Advertisement::where('city_id', $agent->city_id)->latest()->first();
        
        // look for state ads
        if (!$ad) {
            $ad = Advertisement::where('state_id', $agent->state_id)->where('city_id', '')->latest()->first();
        }

        // look for any ads
        // if (!$ad) {
        //     $ad = Advertisement::first();
        // }

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

        $data['version'] = '3.0';

        $data['ads'] = $ads;

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function checkRole(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'role' => 'required'
        ]);

        $user = User::where('mobile', $request->mobile)
                        ->where('role', $request->role)
                        ->first();

        return response()->json(['success' => $user ? true : false]);
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($request->user()->id)],
            'state' => 'required',
            'city'  => 'required',
        ]);

        $user = $request->user();
        $agent = AgentProfile::where('user_id', $request->user()->id)->first();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->state_id = $request->state;
        $user->city_id = $request->city;
        $agent->state = $request->user()->state->name;
        $agent->city = $request->user()->city->name;
        
        $agent->save();

        $user->save();

        return response()->json(['success' => true, 'message' => 'Profile successfully updated.']);
    }

    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image'
        ]);

        $image = $request->image;
        $image_new_name = time() . $image->getClientOriginalName();
        $image->move('uploads/avatars', $image_new_name);

        if($request->user()->avatar !== 'img/user.png') {
            unlink(public_path($request->user()->avatar));
        }

        $request->user()->avatar = 'uploads/avatars/' . $image_new_name;

        $request->user()->save();

        // remove old if not default

        return response()->json(['success' => true, 'message' => 'Profile picture successfully updated.', 'avatar' => $request->user()->avatar]);
    }

    public function logoutApi(Request $request)
    {
        $request->user()->AauthAcessToken()->delete();

        return response()->json(['success' =>true]);
    }

}

