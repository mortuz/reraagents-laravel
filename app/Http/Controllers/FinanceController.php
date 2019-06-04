<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Finance;

class FinanceController extends Controller
{
    public function index()
    {
        return view('finance.index')->with('applications', Finance::latest()->paginate());
    }
}
