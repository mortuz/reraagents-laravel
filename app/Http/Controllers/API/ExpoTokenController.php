<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\ExpoToken;
use App\Http\Controllers\Controller;

class ExpoTokenController extends Controller
{
    public function store(Request $request)
    {
        ExpoToken::updateOrCreate([
            'user_id' => $request->user()->id,
            'device_id' => $request->deviceId,
            'token' => $request->token
        ], []);

        return response()->json(['success' => true]);
    }
}
