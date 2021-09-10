<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Rules\DuplicateRole;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::where('role','EMPLOYEE')->get();
        $data['employees'] = $employees;
        return view('pages.admin.employees.index')->with(compact('data'));
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
            'phone' => ['required', new DuplicateRole([ $request->role ]),'min:10','numeric'],
            'password' => ['required','confirmed','min:6']
        ]);
        $args = $request->all();
        $args['password'] = bcrypt($args['password']);
        $user = User::create($args);

        return redirect()->route('admins.employees.index');
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
        $employee = User::find($id);
        $requestArr = array();
        $validationArr = array();
        $validationArr = [
            'phone' => 'unique:users,phone,'.$id.'|digits:10|numeric',
            'name' => 'string',
            'email' => 'unique:users,email,'.$id.'|email',  
        ];
        if (empty($request->input('password'))) {
            $requestArr = $request->except(['password','password_confirmation']); 
        } else {
            $validationArr['password'] = 'confirmed|min:6';
            $requestArr = $request->all();
            $requestArr['password'] = bcrypt($requestArr['password']);
        }
        $validated = $request->validate($validationArr);
        
        $employee->update($requestArr);
        $employee->save();
        return redirect()->route('admins.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = User::find($id);
        $employee->delete();

        return redirect()->route('admins.employees.index');
    }
}
