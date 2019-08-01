<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;

class StatesController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'data' => State::orderBy('name')->get()]);
    }
}
