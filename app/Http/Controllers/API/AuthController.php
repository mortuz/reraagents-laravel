<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $this->validate($request, [
        //     'email' => 'nullable|email|unique:users,email',
        //     'name'  => 'required',
        //     'state' => 'required',
        //     'city'  => 'required',
        //     'mobile' => 'required|unique:users,mobile'
        // ]);

        
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt('password'),
        //     'mobile' => $request->mobile
        // ]);
            
            // return response(dd($user));
        $guzzle = new Client;

        // $response = $http->post(route('passport.token'), [
        //     'form_params' => [
        //         'grant_type' => 'password',
        //         'client_id' => $request->client_id,
        //         'client_secret' => $request->client_secret,
        //         'username' => $request->mobile,
        //         'password' => $request->password,
        //         'scope' => ''
        //     ]
        // ]);

        $response = $guzzle->post(route('passport.token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'username' => $request->mobile,
                'password' => $request->password,
                'scope' => ''
            ],
        ]);


        return response(['data' => json_encode($response->getBody(), true)]);
    }
}
