<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\User;
use App\AgentProfile;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'nullable|email|unique:users,email',
            'name'  => 'required',
            'state' => 'required',
            'city'  => 'required',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required'
            ]);
            
            
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
            'role' => '5'
        ]);

        AgentProfile::create([
            'state_id' => $request->state,
            'city_id'  => $request->city,
            'user_id'  => $user->id
        ]);
            
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

        return response(['success' => true, 'data' => 'Successfully signed up.']);
    }
}
