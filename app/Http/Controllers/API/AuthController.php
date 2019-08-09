<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\User;
use App\AgentProfile;
use App\Helpers\SmsHelper;

class AuthController extends Controller
{
    public function authCheck(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json(['registered' => false, 'User is not registered.']);
        }
        $code = $this->generateOtp();
        $smsHelper = new SmsHelper;
        $smsHelper->sendPassword($user->mobile, $code);

        $user->password = Hash::make($code);
        $user->save();
        return response()->json(['registered' => true, 'message' => 'OTP is sent to your mobile no.', 'otp' => $code]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'nullable|email|unique:users,email',
            'name'  => 'required',
            'state' => 'required',
            'city'  => 'required',
            'mobile' => 'required|unique:users,mobile',
        ]);

        $code = $this->generateOtp();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($code),
            'mobile' => $request->mobile,
            'state_id' => $request->state,
            'city_id'  => $request->city,
            'role' => '5'
        ]);

        AgentProfile::create([
            'state_id' => $request->state,
            'city_id'  => $request->city,
            'user_id'  => $user->id
        ]);

        // send otp
        $smsHelper = new SmsHelper;
        $smsHelper->sendPassword($user->mobile, $code);
            
        // return response(dd($user));
        // $guzzle = new Client();

        // $response = $guzzle->request('POST', 'http://127.0.0.1:8000/oauth/token', [
        //     'form_params' => [
        //         'grant_type' => 'password',
        //         'client_id' => $request->client_id,
        //         'client_secret' => $request->client_secret,
        //         'username' => $request->mobile,
        //         'password' => $request->password,
        //         'scope' => ''
        //     ],
        // ])->send();

        // dd($response);

        return response(['success' => true, 'data' => 'Successfully signed up.', 'otp' => $code]);
    }

    public function recoverPassword(Request $request)
    {
        // find user
        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json(['success' => false, 'data' => 'Mobile is not registered.']);
        }

        $code = $this->generateOtp();

        // change password
        $user->password = Hash::make($code);
        $user->save();
        // send sms
        $smsHelper = new SmsHelper;
        $smsHelper->sendPassword($request->mobile, $code);

        // return response
        return response()->json(['success' => true, 'message' => 'Your password has been sent to your registered mobile no.']);
    }

    private function generateOtp()
    {
        return substr(str_shuffle("0123456789"), 0, 6);
    }
}
