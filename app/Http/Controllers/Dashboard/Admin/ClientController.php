<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\City;
use App\Model\Duration;
use App\Rules\DuplicateRole;
use App\Model\UserSubscription;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $clients = array();
        // $data['clients'] = User::where('role',"CLIENT")->get();
        
        $notexpired_user_ids = UserSubscription::where('expiry_date','>', date('Y-m-d'))->pluck('user_id');
        $expired_user_ids = UserSubscription::where('expiry_date','<', date('Y-m-d'))->pluck('user_id');
        $subscribed_user_ids = UserSubscription::pluck('user_id');
        $notexpiredUsers = User::where('role',"CLIENT")->whereIn('id',$notexpired_user_ids)->get();
        $expiredUsers = User::where('role',"CLIENT")->whereIn('id',$expired_user_ids)->get();
        $unsubscribedUsers = User::where('role',"CLIENT")->whereNotIn('id',$subscribed_user_ids)->get();
        $clients['subscribed'] = $notexpiredUsers;
        $clients['expired'] = $expiredUsers;
        $clients['unsubscribed'] = $unsubscribedUsers;
        
        $data['clients'] = $clients;
        $data['tab'] = "subscribed";
        return view('pages.admin.clients.index')->with(compact('data'));
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
