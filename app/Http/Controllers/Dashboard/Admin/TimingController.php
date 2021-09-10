<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Timing;
use App\Model\Branch;


class TimingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timings = Timing::all();
        $branches = Branch::all();
        $data['timings'] = $timings;
        $data['branches'] = $branches;
        return view('pages.admin.timings.index')->with(compact('data'));
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
        $args['name_en'] = $name;
        $args['name_ar'] = $name;
        $timing = Timing::create($args);

        return redirect()->route('admins.timings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timing = Timing::find($id);

        $data['timing'] = $timing;
        
        return view('pages.admin.timings.show')->with(compact('data'));
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
        $timing = Timing::find($id);

        $args = $request->all();
        $name = date('g:i a',strtotime($request->start_time))." - ".date('g:i a',strtotime($request->end_time));
        $args['name_en'] = $name;
        $args['name_ar'] = $name;
        $timing->update($args);
        $timing->save();
        return redirect()->route('admins.timings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timing = Timing::find($id);
        $timing->delete();

        return redirect()->route('admins.timings.index');
    }
}
