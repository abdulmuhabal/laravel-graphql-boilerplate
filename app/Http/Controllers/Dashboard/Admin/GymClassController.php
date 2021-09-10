<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GymClass;
use App\Model\WeekDay;


class GymClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weekdays = WeekDay::all();
        $gymclasses = GymClass::all();
        $data['weekdays'] = $weekdays;
        $data['gymclasses'] = $gymclasses;
        return view('pages.admin.gymclasses.index')->with(compact('data'));
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
        $args = $request->all();
        $name = date('g:i a',strtotime($request->start_time))." - ".date('g:i a',strtotime($request->end_time));
        $args['time'] = $name;
        $gymclass = GymClass::create($args);

        return redirect()->route('admins.gymclasses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gymclass = GymClass::find($id);

        $data['gymclass'] = $gymclass;
        
        return view('pages.admin.gymclasses.show')->with(compact('data'));
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
        $gymclass = GymClass::find($id);

        $args = $request->all();
        $name = date('g:i a',strtotime($request->start_time))." - ".date('g:i a',strtotime($request->end_time));
        $args['time'] = $name;
        $gymclass->update($args);
        $gymclass->save();
        return redirect()->route('admins.gymclasses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gymclass = GymClass::find($id);
        $gymclass->delete();

        return redirect()->route('admins.gymclasses.index');
    }
}
