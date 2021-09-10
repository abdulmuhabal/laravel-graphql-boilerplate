<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GymTrainer;
use Illuminate\Support\Facades\Validator;


class GymTrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gymtrainers = GymTrainer::all();
        $data['gymtrainers'] = $gymtrainers;
        return view('pages.admin.gymtrainers.index')->with(compact('data'));
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
            'name' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg'
        ])->validateWithBag('create');

        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admins.gymtrainers.index')
        //         ->withErrors($validator);
        // }

        $gymtrainer = GymTrainer::create($request->all());

        if($request->hasFile('photo'))
        {
            $photo_file = $request->photo;
            $photo_file_filename = $gymtrainer->id.'_photo'.time().'.'.$photo_file->getClientOriginalExtension();
            $photo_file->storeAs('photos',$photo_file_filename);

            $gymtrainer->photo_url = $photo_file_filename;
            $gymtrainer->save();
        }

        return redirect()->route('admins.gymtrainers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gymtrainer = Branch::find($id);

        $data['gymtrainer'] = $gymtrainer;
        
        return view('pages.admin.gymtrainers.show')->with(compact('data'));
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
            'name' => 'required|string',
            'description' => 'required|string',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg'
        ])->validateWithBag("edit".$id);
        
        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admins.gymtrainers.index')
        //         ->withErrors($validator);
        // }

        $gymtrainer = GymTrainer::find($id);
        $gymtrainer->update($request->all());

        if($request->hasFile('photo'))
        {
            $photo_file = $request->photo;
            $photo_file_filename = $gymtrainer->id.'_photo'.time().'.'.$photo_file->getClientOriginalExtension();
            $photo_file->storeAs('photos',$photo_file_filename);

            $gymtrainer->photo_url = $photo_file_filename;
            $gymtrainer->save();
        }

        $gymtrainer->save();
        return redirect()->route('admins.gymtrainers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gymtrainer = GymTrainer::find($id);
        $gymtrainer->delete();

        return redirect()->route('admins.gymtrainers.index');
    }
}
