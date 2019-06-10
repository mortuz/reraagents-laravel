<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Office;
use App\AgentProfile;
use App\State;
use App\PropertyType;

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

        if (request()->city > 0) {
            $filter[] = ['city', $city];
        }

        $filter[] = ['status', 1];

        if (request()->price) {
            $filter[] = ['price', request()->price];
        }

        $properties = Property::where($filter)->latest()->paginate(15);

        foreach ($properties as $property) {
            $property->raw_data = json_decode($property->raw_data);

            if ($property->premium) {
                $property->images = json_decode($property->images);
            }
        }

        $agents = AgentProfile::where('premium', 1)->limit(10)->latest()->get();

        return view('index')->with('properties', $properties)
                            ->with('agents', $agents)
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
        $premium = [];

        if($property->landmarks->first()) {
            $premium[] = $property->landmarks->first()->properties()->take(5)->inRandomOrder()->get();
        }

        if($property->areas->first()) {
            $premium[] = $property->areas->first()->properties()->take(5)->inRandomOrder()->get();
        }

        $premium[] = Property::Where('city_id', $property->city_id)
            ->where('id', '!=', $id)
            ->inRandomOrder()->limit(4)->get();
        

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

        // dd( $premium[0]->take(4));

        if ($property->premium) {
            // $mobile = '';

            // if handled by company i.e., handled_by = 1
            if ($property->handled_by) {
                $office = Office::where('city_id', $property->city_id)->first();
                // return city office no.
                $property->mobile = $office->mobile;
            }

            $property->images = json_decode($property->images);
            $property->features = rtrim($property->features, ';');
            $property->features = explode(';', $property->features);


            return view('frontend.premium-property-detail')
                    ->with('property', $property)
                    ->with('title', $title)
                    ->with('description', $description)
                    ->with('keywords', $keywords)
                    ->with('premiumProperties', $premium[0]->take(4))
                    ;
        } else {
            return view('frontend.property-detail')
                    ->with('property', $property)
                    ->with('office', $office)
                    ->with('title', $title)
                    ->with('description', $description)
                    ->with('keywords', $keywords)
                    ->with('premiumProperties', $premium[0]->take(4))
            ;
        }
    }

    public function about()
    {
        $title = 'About ';
        $description = '';
        $keywords = '';

        return view('frontend.about')
            ->with('title', $title)
            ->with('description', $description)
            ->with('keywords', $keywords);
    }

    public function contact()
    {
        $title = 'Contact ';
        $description = '';
        $keywords = '';

        return view('frontend.contact')
            ->with('title', $title)
            ->with('description', $description)
            ->with('keywords', $keywords);
    }

    public function getSellProperty()
    {
        $title = 'Sell your property ';
        $description = '';
        $keywords = '';

        return view('frontend.sell-property')
            ->with('states', State::all())
            ->with('types', PropertyType::all())
            ->with('title', $title)
            ->with('description', $description)
            ->with('keywords', $keywords);
    }

    public function getTermsAndConditions()
    {
        $title = 'Terms and conditions ';
        $description = '';
        $keywords = '';

        return view('frontend.terms-conditions')
            ->with('title', $title)
            ->with('description', $description)
            ->with('keywords', $keywords);
    }

    public function getPrivacy()
    {
        $title = 'Privacy policy ';
        $description = '';
        $keywords = '';

        return view('frontend.privacy-policy')
                ->with('title', $title)
            ->with('description', $description)
            ->with('keywords', $keywords);
    }
}
