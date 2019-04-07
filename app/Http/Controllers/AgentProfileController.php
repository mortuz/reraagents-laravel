<?php

namespace App\Http\Controllers;

use App\AgentProfile;
use Illuminate\Http\Request;
use App\State;
use App\User;
use Session;
use Illuminate\Validation\Rule;

class AgentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.index')->with('agents', AgentProfile::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agents.create')->with('states', State::all());
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
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required',
            'mobile' => 'required|regex:/[0-9]{10}/|unique:users,mobile',
            'contact_no' => 'nullable|regex:/[0-9]/',
            'state' => 'required|regex:/[1-9]/',
            'city' => 'required|regex:/[1-9]/',
            'address' => 'required',
            'pincode' => 'required|regex:/[0-9]{6}/',
            'pancard' => 'nullable|regex:/^[\w-]*$/',
            'gst' => 'nullable|regex:/^[\w-]*$/',
            'acount_no' => 'nullable|regex:/[1-9]/',
            'bank_name' => 'nullable',
            'ifsc' => 'nullable|regex:/^[\w-]*$/',
        ]);

        // store the request
        // store name, email, phone, password in users table, email verified, mobile, role verified in Users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'role' => 5
        ]);

        // store rest in AgentProfile
        $agent = AgentProfile::create([
            'state_id' => $request->state,
            'city_id' => $request->city,
            'contact_no' => $request->contact_no,
            'user_id' => $user->id,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'pan'   => $request->pancard,
            'gst'   => $request->gst,
            'bank_name' => $request->bank_name,
            'account_no' => $request->account_no,
            'ifsc' => $request->ifsc
        ]);

        Session::flash('success', 'Agent successfully added');
        return redirect()->route('agents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AgentProfile  $agentProfile
     * @return \Illuminate\Http\Response
     */
    public function show(AgentProfile $agentProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AgentProfile  $agentProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentProfile $agent)
    {
        return view('agents.edit')->with('agent', $agent)->with('states', State::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AgentProfile  $agentProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgentProfile $agent)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($agent->user->id)],
            'mobile' => ['required','regex:/[0-9]{10}/', Rule::unique('users', 'mobile')->ignore($agent->user->id)],
            'contact_no' => 'nullable|regex:/[0-9]/',
            'state' => 'required|regex:/[1-9]/',
            'city' => 'required|regex:/[1-9]/',
            'address' => 'required',
            'pincode' => 'required|regex:/[0-9]{6}/',
            'pancard' => 'nullable|regex:/^[\w-]*$/',
            'gst' => 'nullable|regex:/^[\w-]*$/',
            'acount_no' => 'nullable|regex:/[1-9]/',
            'bank_name' => 'nullable',
            'ifsc' => 'nullable|regex:/^[\w-]*$/',
        ]);

        // update data
        $agent->user->name = $request->name;
        $agent->user->email = $request->email;
        $agent->user->mobile = $request->mobile;

        if ($request->password) {
            $agent->user->password = $request->password;
        }

        $agent->user->save();

        // save other information
        $agent->contact_no = $request->contact_no;

        $agent->state_id = $request->state;
        $agent->city_id = $request->city;
        $agent->address = $request->address;
        $agent->pincode = $request->pincode;

        $agent->pan = $request->pancard;
        $agent->gst = $request->gst;

        $agent->account_no = $request->account_no;
        $agent->bank_name = $request->bank_name;
        $agent->ifsc = $request->ifsc;

        $agent->save();

        Session::flash('success', 'Agent successfully added');
        return redirect()->route('agents.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AgentProfile  $agentProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentProfile $agentProfile)
    {
        //
    }
}
