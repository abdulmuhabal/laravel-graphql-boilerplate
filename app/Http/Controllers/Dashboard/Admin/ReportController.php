<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Branch;
use App\Model\Timing;
use App\Model\Booking;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $from = date('Y-m-d');
        // $to = date('Y-m-d', strtotime('today +6 days'));
        $from = "";
        $to = "";
        if($request->has('from'))
            $from = $request->from; 

        if($request->has('to'))
            $to = $request->to;

        
        $data = array();
        $data['from'] = $from;
        $data['to'] = $to;
        // $date_arr = array();
        // for ($i=0; strtotime($from.' + '.$i.' days') <= strtotime($to) ; $i++) {
        //     $timings = Timing::where('branch_id',1)->get();
        //     $date_arr[$i] = array(
        //         'name' => date('m-d-Y',strtotime($from.' + '.$i.' days')),
        //         'timings' => $timings,
        //     );
        // }
        // exit;
        // $data['date_arr'] = $date_arr;
        $booking_dates = Booking::select('booking_date')->groupBy('booking_date')->orderBy('booking_date', 'DESC')->get();
        $data['booking_dates'] = $booking_dates;
        // var_dump($data); exit;

        return view('pages.admin.report.index')->with(compact('data'));
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
        $branch = Branch::create($args);

        return redirect()->route('admins.branches.index');
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

    public function booking_report(Request $request)
    {
        // echo $request->booking_date." ".$request->timing_id;
        $data = array();
        $data['timing'] = Timing::find($request->timing_id);
        $data['booking_date'] = $request->booking_date;
        $data['bookings'] = Booking::where('booking_date', $request->booking_date)->where('timing_id',$request->timing_id)->where('status','!=','CANCELLED')->get();

        return view('pages.admin.report.show')->with(compact('data'));
    }

    public function timing_report(Request $request)
    {
        // echo $request->booking_date." ".$request->timing_id;
        $data = array();
        // $data['bookings'] = Booking::where('booking_date', $request->booking_date)->where('timing_id',$request->timing_id)->where('status','!=','CANCELLED')->get();
        $data['timings'] = Timing::where('branch_id',1)->get();
        $data['booking_date'] = $request->booking_date;

        return view('pages.admin.report.timing')->with(compact('data'));
    }
}
