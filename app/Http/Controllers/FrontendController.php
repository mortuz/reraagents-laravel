<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Office;

class FrontendController extends Controller
{
    public function index()
    {
        $filter = [];
        $city = 0;
        $title = '';
        $description = '';
        $keywords = '';

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

            if ($property->premium) {
                $property->images = json_decode($property->images);
            }
        }

        return view('index')->with('properties', $properties)
                            ->with('title', $title)
                            ->with('description', $description)
                            ->with('keywords', $keywords)
        ;
    }

    public function showProperty($id)
    {
        $property =  Property::find($id);
        $property->raw_data = json_decode($property->raw_data);
        $office = Office::where('city_id', $property->city_id)->first();

        $areas = [];
        $landmarks = [];

        foreach ($property->areas as $area) {
            array_push($areas, $area);
        }
        foreach ($property->landmarks as $landmark) {
            array_push($landmarks, $landmark);
        }

        $title = $property->raw_data->details;
        $description = $property->raw_data->details;
        $keywords = implode(',', $areas);
        $keywords .= implode(',', $landmarks);
        $keywords .= $property->state->name . ',';
        $keywords .= $property->city->name . ',';


        if ($property->premium) {
            $property->images = json_decode($property->images);
            $property->features = rtrim($property->features, ';');
            $property->features = explode(';', $property->features);

            return view('frontend.premium-property-detail')
                    ->with('property', $property)
                    ->with('title', $title)
                    ->with('description', $description)
                    ->with('keywords', $keywords)
                    ;
        } else {
            return view('frontend.property-detail')
                    ->with('property', $property)
                    ->with('office', $office)
                    ->with('title', $title)
                    ->with('description', $description)
                    ->with('keywords', $keywords)
            ;
        }
    }
}
