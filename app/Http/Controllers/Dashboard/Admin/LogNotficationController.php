<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Helpers\OneSignalHelper;
use App\Model\LogNotification;

class LogNotficationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['logNotifications'] = LogNotification::where('user_id_to_notify', 1)->get();
        return view('pages.admin.log-notifications.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        return view('pages.admin.log-notifications.create')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = User::where('role','CLIENT')->get();
        $pushData = array(
            'title_en'=> $request->title,
            'title_ar'=> $request->title,
            'message_en'=> $request->message,
            'message_ar'=> $request->message,
        );
        $filter= "";
        foreach ($users as $key => $user) {
            OneSignalHelper::notification(
                1,
                1, //user_id
                $user->id, //user_id_to_notify
                "ADMIN_NOTIFICATION", //type
                "admin notification", // group
                $filter, // filter
                $pushData
            );
        }

        return redirect()->route('admins.log-notifications.index');
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
        return view('pages.admin.log-notifications.show')->with(compact('data'));
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

        return redirect()->route('admins.log-notifications.show',$id);
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
        $user->delete();

        return redirect()->route('admins.log-notifications.index');
    }
}
