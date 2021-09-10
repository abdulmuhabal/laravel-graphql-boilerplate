<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Consultation;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRequestsData($type)
    {
        $data = array();
        $requests_all = Consultation::where('type',$type)->get();
        $pending = Consultation::where('type',$type)->where('status','PENDING')->get();
        $in_progress = Consultation::where('type',$type)->where('status','IN_PROGRESS')->get();
        $answered = Consultation::where('type',$type)->where('status','ANSWERED')->get();
        $rejected = Consultation::where('type',$type)->where('status','REJECTED')->get();
        $data['requests']['pending'] = $pending;
        $data['requests']['in_progress'] = $in_progress;
        $data['requests']['answered'] = $answered;
        $data['requests']['rejected'] = $rejected;
        
        return $data;
    }

    public function chatRequestIndex(Request $request)
    {
        $data = array();
        // var_dump($data['tab']); exit;
        $data = $this->getRequestsData("CHAT");
        $data['tab'] = 'pending';
        if($request->has('tab')){
            $data['tab'] = $request->tab;
        }
        
        return view('pages.admin.requests.chat')->with(compact('data'));
    }

    public function callRequestIndex(Request $request)
    {
        $data = array();
        // var_dump($data['tab']); exit;
        $data = $this->getRequestsData("CALL");
        $data['tab'] = 'pending';
        if($request->has('tab')){
            $data['tab'] = $request->tab;
        }
        return view('pages.admin.requests.call')->with(compact('data'));
    }

    public function emailRequestIndex(Request $request)
    {
        $data = array();
        // var_dump($data['tab']); exit;
        $data = $this->getRequestsData("EMAIL");
        $data['tab'] = 'pending';
        if($request->has('tab')){
            $data['tab'] = $request->tab;
        }
        return view('pages.admin.requests.email')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        return view('pages.admin.clients.create')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => ['required','min:10','numeric','unique:users'],
            'email' => ['unique:users', 'email'],
            'password' => ['required','confirmed','min:6']
        ]);
        
        $requestArr = $request->all();
        $requestArr['password'] = bcrypt($requestArr['password']);
        $user = User::create($requestArr);

        return redirect()->route('admins.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['client'] = User::find($id);
        $data['durations'] = Duration::all();
        return view('pages.admin.clients.show')->with(compact('data'));
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
        $user = User::find($id);
        $validationArr = array();
        $validationArr = [
            'name' => ['string'],
        ];
        if (empty($request->input('password'))) {
            $requestArr = $request->except(['password','password_confirmation']); 
        } else {
            $validationArr['password'] = ['confirmed','min:6'];
            $requestArr = $request->all();
            $requestArr['password'] = bcrypt($requestArr['password']);
        }
        
        if($request->phone != $user->phone){
            $validationArr['phone'] = ['digits:10','numeric',new DuplicateRole];
        }

        $validated = $request->validate($validationArr);

        
        $user->update($requestArr);
        $user->save();

        return redirect()->route('admins.clients.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        foreach ($user->bookings as $key => $booking) {
            $booking->delete();
        }
        $user->delete();

        return redirect()->route('admins.clients.index');
    }
}
