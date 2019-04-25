<?php

namespace App\Http\Controllers;

use App\Advertisement;
use Illuminate\Http\Request;
use App\State;
use Session;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('advertisement.index')->with('states', State::all())
            ->with('ads', Advertisement::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advertisement.create')->with('states', State::all());
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
            'image' => 'required|image',
            'title' => 'required'
        ]);
        
        $image = $request->image;
        $image_new_name = time() . $image->getClientOriginalName();
        $image->move('uploads/advertisement', $image_new_name);

        $imagesPath = 'uploads/advertisement/' . $image_new_name;

        Advertisement::create([
            'state_id' => $request->state,
            'city_id' => $request->city,
            'link' => $request->link,
            'description' => $request->description,
            'title' => $request->title,
            'image' => $imagesPath
        ]);

        Session::flash('success', 'Advertisement successfully created');
        return redirect()->route('advertisement.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        return view('advertisement.edit')
                    ->with('states', State::all())
                    ->with('ad', $advertisement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        
        if ($request->image) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('uploads/advertisement', $image_new_name);
            $imagesPath = 'uploads/advertisement/' . $image_new_name;
            
            unlink(public_path($advertisement->image));
            
            $advertisement->image = $imagesPath;
        }
        
        $advertisement->state_id = $request->state;
        $advertisement->city_id = $request->city;
        $advertisement->link = $request->link;
        $advertisement->description = $request->description;
        $advertisement->title = $request->title;
        $advertisement->save();

        Session::flash('success', 'Advertisement successfully updated');
        return redirect()->route('advertisement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        unlink(public_path($advertisement->image));

        $advertisement->delete();
        Session::flash('success', 'Advertisement successfully deleted.');
        return redirect()->back();
    }
}
