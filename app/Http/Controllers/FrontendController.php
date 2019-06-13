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
        $premiumProperty = null;

        if($property->landmarks->first()) {
            $premium[] = $property->landmarks->first()->properties()->where('property_id', '!=', $id)->where('status', 1)->take(5)->inRandomOrder()->get();
        }

        if($property->areas->first()) {
            $premium[] = $property->areas->first()->properties()->where('property_id', '!=', $id)->where('status', 1)->take(5)->inRandomOrder()->get();
        }

        $premium[] = Property::where('city_id', $property->city_id)
            ->where('id', '!=', $id)
            ->where('status', 1)
            ->inRandomOrder()->limit(4)->get();
        // dd($premium); 
        // dd( $premium[0]->merge($premium[1]));
    
        if( array_key_exists('1', $premium)) {
                $premiumProperty = $premium[0]->merge($premium[1]);
        }
        
        if( array_key_exists('2', $premium)) {
            if ($premiumProperty) {
                $premiumProperty = $premiumProperty->merge($premium[2]);
            } else {
                $premiumProperty = $premium[0]->merge($premium[2]);
            }
        }

        // dd( $premiumProperty);

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
                    ;
        } else {
            return view('frontend.property-detail')
                    ->with('property', $property)
                    ->with('office', $office)
                    ->with('title', $title)
                    ->with('description', $description)
                    ->with('keywords', $keywords)
                    ->with('premiumProperties', $premiumProperty ? $premiumProperty->take(4) : [])
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

    public function getAgentDetails($id)
    {
        $agent = AgentProfile::where('id', $id)->where('premium', 1)->first();

        if (!$agent) {
            return redirect()->back();
        }

        $title = $agent->user->name . ' ';
        $description = '';
        $keywords = '';

        $premium = [];
        $premiumAgents = null;

        if ($agent->area_id) {
            $premium[] = AgentProfile::where('area_id', '!=', $id)->where('premium', 1)->take(5)->inRandomOrder()->get();
        }

        if ($agent->landmark_id) {
            $premium[] = AgentProfile::where('landmark_id', '!=', $id)->where('premium', 1)->take(5)->inRandomOrder()->get();
        }

        $premium[] = AgentProfile::where('city_id', $agent->city_id)
            ->where('id', '!=', $id)
            ->where('premium', 1)
            ->inRandomOrder()->limit(4)->get();

        if (array_key_exists('1', $premium)) {
            $premiumAgents = $premium[0]->merge($premium[1]);
        }

        if (array_key_exists('2', $premium)) {
            if ($premiumAgents) {
                $premiumAgents = $premiumAgents->merge($premium[2]);
            } else {
                $premiumAgents = $premium[0]->merge($premium[2]);
            }
        }

        return view('frontend.agent-details')
            ->with('title', $title)
            ->with('description', $description)
            ->with('keywords', $keywords)
            ->with('agent', $agent)
            ->with('premiumAgents', $premiumAgents ? $premiumAgents->take(6) : [])
            ;
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
