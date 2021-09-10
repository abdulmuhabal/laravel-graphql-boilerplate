<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Advertisement;
use Illuminate\Support\Facades\Validator;


class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::all();
        $data['advertisements'] = $advertisements;
        return view('pages.admin.advertisements.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg'
        ])->validateWithBag('create');

        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admins.advertisements.index')
        //         ->withErrors($validator);
        // }

        $advertisement = Advertisement::create($request->all());

        if($request->hasFile('photo'))
        {
            $photo_file = $request->photo;
            $photo_file_filename = $advertisement->id.'_photo'.time().'.'.$photo_file->getClientOriginalExtension();
            $photo_file->storeAs('advertisements',$photo_file_filename);

            $advertisement->photo_url = $photo_file_filename;
            $advertisement->save();
        }

        return redirect()->route('admins.advertisements.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Branch::find($id);

        $data['advertisement'] = $advertisement;
        
        return view('pages.admin.advertisements.show')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg'
        ])->validateWithBag("edit".$id);
        
        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admins.advertisements.index')
        //         ->withErrors($validator);
        // }

        $advertisement = Advertisement::find($id);
        $advertisement->update($request->all());

        if($request->hasFile('photo'))
        {
            $photo_file = $request->photo;
            $photo_file_filename = $advertisement->id.'_photo'.time().'.'.$photo_file->getClientOriginalExtension();
            $photo_file->storeAs('advertisements',$photo_file_filename);

            $advertisement->photo_url = $photo_file_filename;
            $advertisement->save();
        }

        $advertisement->save();
        return redirect()->route('admins.advertisements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->delete();

        return redirect()->route('admins.advertisements.index');
    }
}
