<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;

class FrontendController extends Controller
{
    public function index()
    {
        $filter = [];
        $city = 0;

        // $filter[] = ['state', $request->getParam('state')];

        if (request()->city> 0) {
            $filter[] = ['city', $city];
        }

        $filter[] = ['status', 1];

        if (request()->price) {
            $filter[] = ['price', request()->price];
        }

        $properties = Property::where($filter)->paginate(15);

        foreach ($properties as $property) {
            $property->raw_data = json_decode($property->raw_data);
        }

        // $properties->transform(function ($property) {
        //     return [
        //         'id'            => $property->id,
        //         'state'         => $property->state->name,
        //         'city'          => $property->city->name,
        //         'features'      => $property->features,
        //         'premium'       => $property->premium,
        //         'property_type' => $property->propertytypes->first()->type,
        //         'area'          => count($property->areas) == 0 ? null : $property->areas->first()->area,
        //         'measurement'   => json_decode($property->raw_data)->measurement,
        //         'price'         => $property->prices->first()->price,
        //         'heading'       => json_decode($property->raw_data)->details,
        //         'raw'           => json_decode($property->raw_data),
        //         'images'        => $property->images,
        //         'google_map'    => $property->google_map,
        //         'created_at'    => $property->created_at,
        //         'updated_at'    => $property->updated_at,
        //         'expiry_date'   => $property->expiry_date,
        //     ];
        // });

        // dd($properties);

        return view('frontend')->with('properties', $properties);
    }
}
