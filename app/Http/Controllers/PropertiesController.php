<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\State;
use App\User;
use App\Property;
use App\AgentProfile;
use Illuminate\Http\Request;
use App\Feedback;
use Notification;
use Illuminate\Support\Facades\DB;
use App\Notifications\PropertyApprovedNotification;
use App\Notifications\PropertyRejectededNotification;
use App\Notifications\PremiumPropertyNotification;
use Illuminate\Support\Carbon;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = null;
        $filter = [];
        if (!empty($request->state)) {
            $filter[] = ['state_id', $request->state];
        }
        if (!empty($request->city)) {
            $filter[] = ['city_id', $request->city];
        }
        if ($request->status != '') {
            $filter[] = ['status', $request->status];
        }
        $results = Property::where($filter);

        if(!empty($request->type)) {
            $results->whereHas('propertytypes', function($query) use ($request) {
                $query->whereIn('property_type_id', explode(',', $request->type));
            });
        }
        if(!empty($request->area)) {
            $results->whereHas('areas', function($query) use ($request) {
                $query->whereIn('area_id', explode(',', $request->area));
            });
        }
        if(!empty($request->price)) {
            $results->whereHas('prices', function($query) use ($request) {
                $query->whereIn('price_id', explode(',', $request->price));
            });
        }
        $results = $results->orderBy('expiry_date', 'desc')->paginate()->appends([
            'state' => $request->state,
            'city' => $request->city,
            'type' => $request->type,
            'areas' => $request->area,
            'prices' => $request->price,
            'status' => $request->status,
        ]);
        // dd( Property::where($filter)->latest()->paginate());
        
        return view('properties.index')
                ->with('properties', $results)
                ->with('states', State::all())
                ->with('filters', [
                    'state' => $request->state,
                    'city' => $request->city,
                    'type' => $request->type,
                    'areas' => $request->area,
                    'prices' => $request->price,
                    'status' => $request->status,
                ])
                ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token = Auth::user()->tokens()->latest()->first() ? Auth::user()->tokens()->latest()->first()->id : null;
        return view('properties.create')
                        ->with('token', $token)
                        ->with('states', State::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'state' => 'required',
            'city' => 'required|regex:/[1-9]/',
            'price' => 'required',
            'contact' => 'required|max:10',
            'handler' => 'required',
            'status' => 'required',
            'raw_price' => 'required',
            'raw_measurement' => 'required',
            'raw_location' => 'required',
            'raw_details' => 'required'
        ]);

        $property = Property::create([
            'state_id' => $request->state,
            'city_id' => $request->city,
            'handler' => $request->handler,
            'status' => $request->status,
            'mobile' => $request->contact,
            'expiry_date' => Carbon::now()->addDays('30'),
            'user_id' => Auth::id(),
            'premium' => $request->premium ? $request->premium : 0,
            'office_id' => $request->office ? $request->office : 0,
            'raw_data' => json_encode([
                'price' => $request->price,
                'measurement' => $request->measurement,
                'location' => $request->location,
                'details' => $request->details
            ]),
        ]);

        if ($request->bhk) {
            $property->rooms()->attach(explode(',', $request->bhk));
        }
        
        if ($request->face) {
            $property->faces()->attach(explode(',', $request->face));
        }

        if ($request->area) {
            $property->areas()->attach(explode(',', $request->area));
        }

        if ($request->landmark) {
            $property->landmarks()->attach(explode(',', $request->landmark));
        }

        if ($request->price) {
            $property->prices()->attach(explode(',', $request->price));
        }

        if ($request->type) {
            $property->propertytypes()->attach(explode(',', $request->type));
        }

        if ($request->builders) {
            $property->builders()->attach(explode(',', $request->builders));
        }

        if ($request->agents) {
            $property->agents()->attach(explode(',', $request->agents));
        }

        if ($request->ventures) {
            $property->ventures()->attach(explode(',', $request->ventures));
        }

        Session::flash('success', 'Property successfully added.');
        return redirect()->route('properties.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $property->rooms = implode(',', $property->rooms()->pluck('b_h_k_s.id')->toArray());
        $property->area = implode(',', $property->areas()->pluck('areas.id')->toArray());
        $property->landmark = implode(',', $property->landmarks()->pluck('landmarks.id')->toArray());
        $property->face = implode(',', $property->faces()->pluck('faces.id')->toArray());
        $property->price = implode(',', $property->prices()->pluck('prices.id')->toArray());
        $property->type = implode(',', $property->propertytypes()->pluck('property_types.id')->toArray());

        $property->agents = implode(',', $property->agents()->pluck('agent_profiles.id')->toArray());
        $property->builders = implode(',', $property->builders()->pluck('builder_profiles.id')->toArray());
        $property->ventures = implode(',', $property->ventures()->pluck('ventures.id')->toArray());
        $property->raw = json_decode($property->raw_data, true);

        $token = DB::table('oauth_access_tokens')->where('user_id', Auth::id())->latest()->first()->id;

        return view('properties.edit')
                ->with('token', $token)
                ->with('property', $property)
                ->with('states', State::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {

        // dd($request->price);
        $this->validate($request, [
            'state' => 'required',
            'city' => 'required|regex:/[1-9]/',
            'contact' => 'required|max:10',
            'handler' => 'required',
            'status' => 'required',
            'raw_price' => 'required',
            'raw_measurement' => 'required',
            'raw_location' => 'required',
            'raw_details' => 'required'
        ]);

        $property->state_id = $request->state;
        $property->city_id = $request->city;
        $property->handled_by = $request->handler;
        $property->mobile = $request->contact;
        $property->premium = $request->premium ? $request->premium : 0;
        $property->office_id =  $request->office ? $request->office : 0;

        $raw_data = json_encode([
            'price' => $request->raw_price,
            'measurement' => $request->raw_measurement,
            'location' => $request->raw_location,
            'details' => $request->raw_details
        ]);

        $property->raw_data = $raw_data;

        if ($request->bhk) {
            $property->rooms()->sync(explode(',', $request->bhk));
        } else {
            $property->rooms()->detach();
        }
        
        if ($request->face) {
            $property->faces()->sync(explode(',', $request->face));
        } else {
            $property->faces()->detach();
        }

        if ($request->area) {
            $property->areas()->sync(explode(',', $request->area));
        } else {
            $property->areas()->detach();
        }

        if ($request->landmark) {
            $property->landmarks()->sync(explode(',', $request->landmark));
        } else {
            $property->landmarks()->detach();
        }

        if ($request->price) {
            $property->prices()->sync(explode(',', $request->price));
        } else {
            $property->prices()->detach();
        }

        if ($request->type) {
            $property->propertytypes()->sync(explode(',', $request->type));
        } else {
            $property->propertytypes()->detach();
        }

        if ($request->builders) {
            $property->builders()->sync(explode(',', $request->builders));
        } else {
            $property->builders()->detach();
        }

        if ($request->agents) {
            $property->agents()->sync(explode(',', $request->agents));
        } else {
            $property->agents()->detach();
        }

        if ($request->ventures) {
            $property->ventures()->sync(explode(',', $request->ventures));
        } else {
            $property->ventures()->detach();
        }

        // if status rejected i.e., status == 2
        $feedback = Feedback::firstOrNew(['property_id' => $property->id]);
        if ($request->status == 2) {
            $feedback->message = $request->message;
            $feedback->save();
        } else {
            $feedback->message = '';
            $feedback->save();
        }

        // send notification

        if ($request->status != $property->status) {
            if ($property->user) {
                if ($request->status == 1) {
                    Notification::send($property->user, new PropertyApprovedNotification($property));
                }

                if ($request->status == 2) {
                    Notification::send($property->user, new PropertyRejectededNotification($property));
                }
            }
        }

        $property->status = $request->status;
        $property->save();

        if ($request->premium) {
            return redirect()->route('property.premium.edit', ['property' => $property->id]);
        } else {
            Session::flash('success', 'Property successfully updated.');
            return redirect()->route('properties.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //detach area
        $property->areas()->detach();
        //detach room
        $property->rooms()->detach();
        //detach face
        $property->faces()->detach();
        //detach landmark
        $property->landmarks()->detach();
        //detach price
        $property->prices()->detach();
        //detach propertytype
        $property->propertytypes()->detach();
        //detach builders
        $property->builders()->detach();
        //detach agents
        $property->agents()->detach();
        //detach ventures
        $property->ventures()->detach();
        // delete property
        $property->delete();

        Session::flash('success', 'Property successfully deleted.');
        return redirect()->back();
    }

    public function premiumEdit(Property $property)
    {
        return view('properties.premium.edit')->with('property', $property);
    }

    public function premiumUpdate(Request $request, Property $property)
    {
        // dd($request->all());
        $this->validate($request, [
            'website' => 'nullable|regex:/^\S*$/u',
            'youtube_link' => 'nullable|regex:/^\S*$/u',
            'google_map' => 'nullable|regex:/^\S*$/u'
        ]);

        $images = [];

        if ($request->images) {
            foreach ($request->images as $image) {
                $image_new_name = time() . $image->getClientOriginalName();
                $image->move('uploads/properties', $image_new_name);

                $images[] = 'uploads/properties/' . $image_new_name;
            }

            if ($property->images) {
                $oldImages = json_decode($property->images);

                foreach ($oldImages as $image) {
                    unlink(public_path($image));
                }
            }
        }

        $property->website = $request->website;
        $property->youtube_link = $request->youtube_link;
        $property->google_map = $request->google_map;
        $property->features = $request->features;

        if ($request->images || !$property->images) {
            $property->images = json_encode($images);
        }

        $property->save();

        $agents = AgentProfile::where('city_id', $property->city_id)->get();
        $users = [];

        foreach ($agents as $agent) {
            array_push($users, $agent->user);
        }

        Notification::send($users, new PremiumPropertyNotification($property));

        Session::flash('success', 'Property successfully updated.');
        return redirect()->route('properties.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRequestDelete(Request $request)
    {
        $results = null;
        $filter[] = ['inactive', 1];
        if (!empty($request->state)) {
            $filter[] = ['state_id', $request->state];
        }
        if (!empty($request->city)) {
            $filter[] = ['city_id', $request->city];
        }
        if ($request->status != '') {
            $filter[] = ['status', $request->status];
        }
        $results = Property::where($filter);

        if (!empty($request->type)) {
            $results->whereHas('propertytypes', function ($query) use ($request) {
                $query->whereIn('property_type_id', explode(',', $request->type));
            });
        }
        if (!empty($request->area)) {
            $results->whereHas('areas', function ($query) use ($request) {
                $query->whereIn('area_id', explode(',', $request->area));
            });
        }
        if (!empty($request->price)) {
            $results->whereHas('prices', function ($query) use ($request) {
                $query->whereIn('price_id', explode(',', $request->price));
            });
        }
        $results = $results->latest()->paginate()->appends([
            'state' => $request->state,
            'city' => $request->city,
            'type' => $request->type,
            'areas' => $request->area,
            'prices' => $request->price,
            'status' => $request->status,
        ]);
        // dd( Property::where($filter)->latest()->paginate());

        return view('properties.delete')
            ->with('properties', $results)
            ->with('states', State::all())
            ->with('filters', [
                'state' => $request->state,
                'city' => $request->city,
                'type' => $request->type,
                'areas' => $request->area,
                'prices' => $request->price,
                'status' => $request->status,
            ]);
    }

    public function renew(Property $property)
    {
        $property->expiry_date = Carbon::now()->addDays('30');
        $property->save();
        Session::flash('success', 'Property has been renewed');
        return redirect()->back();
    }
}
