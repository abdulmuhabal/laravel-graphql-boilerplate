<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Model\OldClient;
use App\Model\Booking;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $data = array();
        

        // $completed_weekly_count = array();
        // $data['clients_count'] = User::where('role','CLIENT')->get()->count();
        // $data['unsbuscribe_count'] = User::where('role','CLIENT')
        //     ->where(function ($query) {
        //         $query->where('expiry_date', '<',date('Y-m-d') )
        //             ->orWhereNull('expiry_date');
        //     })->get()->count();
 
        // $data['bookings_today_count'] = Booking::where('booking_date', date('Y-m-d'))->where('status','!=', 'CANCELED')->get()->count();  
        // $data['bookings_count'] = Booking::where('status','!=', 'CANCELED')->get()->count();  
        // $phones = "";
        // $expiries = "";
        // $maxDays = date('t');
        // $data['bookings_per_day'] = array();
        // $data['bookings_str'] = "";
        // $data['bookings_days_str'] = "";

        // // echo date('Y-m-d',strtotime("now -7 days")); exit;

        // for ($i=1; $i <= $maxDays; $i++) { 
        //     $data['bookings_per_day'][$i] = Booking::where('booking_date', date('Y-m-d',strtotime(date('Y-m-'.$i))))->where('status','!=', 'CANCELED')->get()->count();  
        //     $data['bookings_str'] .= Booking::where('booking_date', date('Y-m-d',strtotime(date('Y-m-'.$i))))->where('status','!=', 'CANCELED')->get()->count();
        //     $data['bookings_days_str'] .= $i;
        //     if($i < $maxDays){
        //         $data['bookings_str'] .= ",";
        //         $data['bookings_days_str'] .= ",";
        //     }    
        // }

        // $data['bookings_week_str'] = "";

        // for ($n=6; $n >= 0; $n--) {
        //     $data['bookings_week_str'] .= Booking::where('booking_date', date('Y-m-d',strtotime("now -".$n." days")))->where('status','!=', 'CANCELED')->get()->count(); 
        //     if($n > 0){
        //         $data['bookings_week_str'] .= ",";
        //     }  
        // }
        $data['clients_count'] = 0;
        $data['unsbuscribe_count'] = 0;
        $data['bookings_today_count'] = 0;
        $data['bookings_count'] = 0;
        return view('pages.admin.dashboard.index')->with(compact('data'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

