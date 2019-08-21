<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\State;
use App\Requirement;
use App\AgentProfile;
use App\CustomerStatus;
use App\RequirementMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequirementApprovedNotification;
use App\Notifications\RequirementRejectedNotification;
use App\Notifications\RequirementCommentAddedNotification;
use App\Notifications\RequirementReleasedNotification;
use App\Notifications\NewRequirementAvailableNotification;

class RequirementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('requirements.index')->with('requirements', Requirement::latest()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token = Auth::user()->tokens()->latest()->first()->id;
        return view('requirements.create')
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
            'budget' => 'required',
            'contact' => 'required|max:10',
            'handler' => 'required',
            'status' => 'required',
            // 'budget' => 'required',
            // 'details' => 'required'
        ]);

        $requirement = Requirement::create([
            'state_id' => $request->state,
            'city_id' => $request->city,
            'handler' => $request->handler,
            'status' => $request->status,
            'mobile' => $request->contact,
            'user_id' => Auth::id(),
            'premium' => $request->premium ? $request->premium : 0,
            'office_id' => $request->office ? $request->office : 0,
            'raw_data' => json_encode([
                'budget' => $request->raw_budget,
                'details' => $request->raw_details
            ])
        ]);

        if ($request->bhk) {
            $requirement->rooms()->attach(explode(',', $request->bhk));
        }

        if ($request->face) {
            $requirement->faces()->attach(explode(',', $request->face));
        }

        if ($request->area) {
            $requirement->areas()->attach(explode(',', $request->area));
        }

        if ($request->landmark) {
            $requirement->landmarks()->attach(explode(',', $request->landmark));
        }

        if ($request->budget) {
            $requirement->prices()->attach(explode(',', $request->budget));
        }

        if ($request->type) {
            $requirement->propertytypes()->attach(explode(',', $request->type));
        }

        if ($request->builders) {
            $requirement->builders()->attach(explode(',', $request->builders));
        }

        if ($request->agents) {
            $requirement->agents()->attach(explode(',', $request->agents));
        }

        if ($request->ventures) {
            $requirement->ventures()->attach(explode(',', $request->ventures));
        }

        Session::flash('success', 'Requirement successfully added.');
        return redirect()->route('requirement.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(Requirement $requirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function edit(Requirement $requirement)
    {
        $requirement->rooms = implode(',', $requirement->rooms()->pluck('b_h_k_s.id')->toArray());
        $requirement->area = implode(',', $requirement->areas()->pluck('areas.id')->toArray());
        $requirement->landmark = implode(',', $requirement->landmarks()->pluck('landmarks.id')->toArray());
        $requirement->face = implode(',', $requirement->faces()->pluck('faces.id')->toArray());
        $requirement->price = implode(',', $requirement->prices()->pluck('prices.id')->toArray());
        $requirement->type = implode(',', $requirement->propertytypes()->pluck('property_types.id')->toArray());

        $requirement->agents = implode(',', $requirement->agents()->pluck('agent_profiles.id')->toArray());
        $requirement->builders = implode(',', $requirement->builders()->pluck('builder_profiles.id')->toArray());
        $requirement->ventures = implode(',', $requirement->ventures()->pluck('ventures.id')->toArray());
        $requirement->raw = json_decode($requirement->raw_data, true);

        $token = Auth::user()->tokens()->latest()->first()->id;
        return view('requirements.edit')
            ->with('token', $token)
            ->with('requirement', $requirement)
            ->with('states', State::all())
            ->with('cstatus', CustomerStatus::all())
            ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requirement $requirement)
    {
        $this->validate($request, [
            'state' => 'required',
            'city' => 'required|regex:/[1-9]/',
            'contact' => 'required|max:10',
            'handler' => 'required',
            'status' => 'required',
            'raw_budget' => 'required',
            'raw_details' => 'required'
        ]);

        $requirement->state_id = $request->state;
        $requirement->office_id = $request->office ? $request->office : 0;
        $requirement->city_id = $request->city;
        $requirement->handled_by = $request->handler;
        $requirement->mobile = $request->contact;

        $raw_data = json_encode([
            'budget' => $request->raw_budget,
            'details' => $request->raw_details
        ]);
        $requirement->raw_data = $raw_data;

        if($request->call_date) {
            $requirement->call_date = $request->call_date;
        }

        if($request->visit_date) {
            $requirement->visit_date = $request->visit_date;
        }

        if ($request->bhk) {
            $requirement->rooms()->sync(explode(',', $request->bhk));
        }

        if ($request->face) {
            $requirement->faces()->sync(explode(',', $request->face));
        }

        if ($request->area) {
            $requirement->areas()->sync(explode(',', $request->area));
        }

        if ($request->landmark) {
            $requirement->landmarks()->sync(explode(',', $request->landmark));
        }

        if ($request->price) {
            $requirement->prices()->sync(explode(',', $request->price));
        }

        if ($request->type) {
            $requirement->propertytypes()->sync(explode(',', $request->type));
        }

        if ($request->builders) {
            $requirement->builders()->sync(explode(',', $request->builders));
        }

        if ($request->agents) {
            $requirement->agents()->sync(explode(',', $request->agents));
        }

        if ($request->ventures) {
            $requirement->ventures()->sync(explode(',', $request->ventures));
        }

        if($request->release == 1) {
            $requirement->working_agent = 0;
            $requirement->customer_status_id = null;
            $requirement->visit_date = null;
            $requirement->call_date = null;

            $agents = AgentProfile::where('city_id', $requirement->city_id)->get();
            $users = [];

            foreach ($agents as $agent) {
                if ($requirement->user_id == $agent->user_id || $request->user()->id == $agent->user_id) continue;
                array_push($users, $agent->user);
            }

            Notification::send($users, new NewRequirementAvailableNotification($requirement));
        }

        if ($request->release_message) {
            RequirementMessage::create([
                'requirement_id' => $requirement->id,
                'user_id' => Auth::id(),
                'message' => $request->release_message
            ]);
            
            if($requirement->user_id > 0) {
                Notification::send($requirement->user, new RequirementCommentAddedNotification($requirement));
            }
        }
        

        // send notification
        if ($request->status != $requirement->status) {
            if ($requirement->user_id > 0) {

                switch($request->status) {
                    case 1:
                        Notification::send($requirement->user, new RequirementReleasedNotification($requirement));
                        $agents = AgentProfile::where('city_id', $requirement->city_id)->get();
                        $users = [];

                        foreach ($agents as $agent) {
                            if ( $requirement->user_id == $agent->user_id) continue;
                            array_push($users, $agent->user);
                        }
                        Notification::send($users, new NewRequirementAvailableNotification($requirement));
                        break;
                    case 2:
                        Notification::send($requirement->user, new RequirementApprovedNotification($requirement));
                        break;
                    case 3:
                        Notification::send($requirement->user, new RequirementRejectedNotification($requirement));
                        break;
                    default:
                        break;
                }
            } else {
                if ($request->status == 1) {
                    $agents = AgentProfile::where('city_id', $requirement->city_id)->get();
                    $users = [];
                    foreach ($agents as $agent) {
                        if ($requirement->user_id == $agent->user_id) continue;
                        array_push($users, $agent->user);
                    }
                    Notification::send($users, new NewRequirementAvailableNotification($requirement));
                }
            }
        }

        $requirement->status = $request->status;
        $requirement->save();

        Session::flash('success', 'Requirement successfully updated.');
        return redirect()->route('requirement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requirement $requirement)
    {
        //detach area
        $requirement->areas()->detach();
        //detach room
        $requirement->rooms()->detach();
        //detach face
        $requirement->faces()->detach();
        //detach landmark
        $requirement->landmarks()->detach();
        //detach price
        $requirement->prices()->detach();
        //detach propertytype
        $requirement->propertytypes()->detach();
        //detach builders
        $requirement->builders()->detach();
        //detach agents
        $requirement->agents()->detach();
        //detach ventures
        $requirement->ventures()->detach();
        // delete property
        $requirement->delete();

        Session::flash('success', 'Requirement successfully deleted.');
        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDeleteRequests(Request $request)
    {
        $filter[] = ['request_delete', 1];

        $requirements = Requirement::where($filter)->latest()->paginate();

        return view('requirements.delete')
            ->with('requirements', $requirements);
    }
}
