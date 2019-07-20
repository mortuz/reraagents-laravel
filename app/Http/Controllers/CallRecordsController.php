<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CallRecord;

class CallRecordsController extends Controller
{
    public function index()
    {
        return view('call-records.index')->with('callRecords', CallRecord::paginate());
    }
}
