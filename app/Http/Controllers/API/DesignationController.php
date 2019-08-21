<?php

namespace App\Http\Controllers\API;

use App\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::all()->transform(function ($designation) {
            return [
                'name' => $designation->designation,
                'id'   => $designation->id
            ];
        });
        return response()->json(['success' => true, 'data' => $designations]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Designation::create([
            'designation' => $request->name,
            'slug' => str_slug($request->name),
        ]);

        return response()->json(['success' => true, 'message' => 'Designation created successfully']);
    }
}
