<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\OldClient;
use App\Rules\DuplicateRole;
use App\User;

class OldClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phones = OldClient::all();
        $data['phones'] = $phones;
        return view('pages.admin.old-clients.index')->with(compact('data'));
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
        
        $validatedData = $request->validate([
            'phone' => ['required','min:10','numeric'],
            'expiry_date' => ['required']
        ]);
        $args = $request->all();

        $oldclient = OldClient::create($args);

        $user = User::where('phone',$oldclient->phone)->first();
        if($user){
            $user->expiry_date = $oldclient->expiry_date;
            $user->save();
        }
        

        return redirect()->route('admins.old-clients.index');
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
        $data = array();
        $old_client = OldClient::find($id);
        $data['old_client'] = $old_client;
        return view('pages.admin.old-clients.edit')->with(compact('data'));
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
        $oldclient = OldClient::find($id);
        
        $validationArr = array();
        $validationArr = [
            'phone' => 'digits:10|numeric',
        ];
        $requestArr = $request->all();
        $oldclient->update($requestArr);
        $oldclient->save();
        return redirect()->route('admins.old-clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = OldClient::find($id);
        $employee->delete();

        return redirect()->route('admins.employees.index');
    }
}
