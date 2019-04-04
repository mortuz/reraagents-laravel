<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\BuilderProfile;
use App\Venture;
use App\User;
use Session;

class BuilderProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('builders.index')->with('builders', BuilderProfile::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('builders.create')->with('states', State::all())->with('ventures', Venture::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'city' => 'required',
            'mobile' => 'required',
            'password' => 'required',
        ]);

        // name, email. mobile and passowrd in users table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'role' => 4
        ]);

        // state, city, alternative number, alternative number2, user_id
        $builderProfile = BuilderProfile::create([
            'state_id' => $request->state,
            'city_id' => $request->city,
            'contact_no' => $request->contact_no,
            'alternative_contact_no' => $request->alternative_contact_no,
            'user_id' => $user->id
        ]);


        // ventures
        $builderProfile->ventures()->attach($request->ventures);

        Session::flash('success', 'Builder successfully added.');
        return redirect()->route('builders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('builders.edit')->with('builder', BuilderProfile::find($id))->with('states', State::all())->with('ventures', Venture::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuilderProfile $builder)
    {
        // dd($builder);
        
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'city' => 'required',
            'mobile' => 'required',
        ]);

        // $builder = BuilderProfile::find($id);

        $builder->user->name = $request->name;
        $builder->user->email = $request->email;
        $builder->user->mobile = $request->mobile;

        if ($request->password != '') {
            $builder->user->password = $request->password;
        }

        $builder->user->save();

        $builder->state_id = $request->state;
        $builder->city_id = $request->city;
        $builder->contact_no = $request->contact_no;
        $builder->alternative_contact_no = $request->alternative_contact_no;
        $builder->save();

        $builder->ventures()->sync($request->ventures);


        Session::flash('success', 'Builder successfully updated.');
        return redirect()->route('builders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuilderProfile $builder)
    {
        $builder->user->delete();
        $builder->ventures()->delete();
        $builder->delete();

        Session::flash('success', 'Builder successfully deleted.');
        return redirect()->route('builders.index');
    }
}
