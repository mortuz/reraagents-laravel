<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\State;
use Session;
use Illuminate\Validation\Rule;

class CallerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('callers.index')->with('callers', User::where('role', 2)->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('callers.create')->with('states', State::all());
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
            'state' => 'required',
            'city' => 'required|min:1',
            'email' => 'nullable|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'state' => 'required',
            'city' => 'required',
            'password' => 'required',
        ]);

        // name, email. mobile and passowrd in users table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'state_id' => $request->state,
            'city_id' => $request->city,
            'role' => 2
        ]);
        
        Session::flash('success', 'Caller successfully created.');
        return redirect()->route('callers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $caller)
    {

        return view('callers.edit')->with('states', State::all())
                        ->with('caller', $caller);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $caller)
    {
        $request = request();

        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'city' => 'required|min:1',
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($caller->id)],
            'mobile' => ['required', 'regex:/[0-9]{10}/', Rule::unique('users', 'mobile')->ignore($caller->id)],
        ]);

        $caller->name = $request->name;
        $caller->email = $request->email;
        $caller->mobile = $request->mobile;

        if($request->password) {
            $caller->password = bcrypt($request->password);
        }

        $caller->save();

        Session::flash('success', 'Caller successfully updated.');
        return redirect()->route('callers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
