<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Booking;
use App\Model\Timing;
use App\Model\LogNotification;
use App\Helpers\OneSignalHelper;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if($request->has('from_date') && $request->has('to_date')){
        //     $bookings = Booking::whereBetween('created_at', [$request->from_date, $request->to_date])->get();
        // } else {
        //     $bookings = Booking::all();
        // }

        // $todayBookings = Booking::where('booking_date',date('Y-m-d'))->get();
        
        // $data['bookings'] = $bookings;
        // $data['todayBookings'] = $todayBookings;
        // $data['from_date'] = $request->from_date;
        // $data['to_date'] = $request->to_date;
        $data = array();
        $bookings = array();
        $bookingsAll = Booking::where('status','!=','CANCELLED')->get();
        $timings = Timing::where('branch_id',1)->get();
        $today = array();
        $tomorrow = array();
        foreach ($timings as $key => $timing) {
            $today[$timing->id]['bookings'] = Booking::where('booking_date', date('Y-m-d'))->where('timing_id',$timing->id)->where('status','!=','CANCELLED')->get();
            $today[$timing->id]['name'] = $timing->name_ar;
            $tomorrow[$timing->id]['bookings'] = Booking::where('booking_date', date('Y-m-d', strtotime('today +1 day')))->where('timing_id',$timing->id)->where('status','!=','CANCELLED')->get();
            $tomorrow[$timing->id]['name'] = $timing->name_ar;
        }
        $bookings['today'] = $today;
        $bookings['tomorrow'] = $tomorrow;
        
        $data['bookings'] = $bookings;
        if($request->has('bookings_tab')){
            $data['bookings_tab'] = $request->bookings_tab;
        } else {
            $data['bookings_tab'] = 'today';
        }
        if($request->has('timings_tab')){
            $data['timings_tab'] = $request->timings_tab;
        } else {
            $data['timings_tab'] = 1;

        }
        
        
        
        $data['booking_all'] = $bookingsAll;
        $data['cancelled_bookings'] = Booking::whereBetween('booking_date',[ date('Y-m-d'), date('Y-m-d',strtotime('tomorrow')) ])->where('status','CANCELLED')->get();
        return view('pages.admin.bookings.index')->with(compact('data'));
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
        $booking = Booking::find($id);

        $data['booking'] = $booking;
        
        return view('pages.admin.bookings.show')->with(compact('data'));
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
        $booking = Booking::find($id);
        $booking->update($request->all());
        $booking->save();
        return redirect()->route('admins.bookings.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        $booking->delete();

        return redirect()->route('admins.bookings.index');
    }

    public function attended($id,Request $request)
    {
        $data = array();
        $data['bookings_tab'] = $request->bookings_tab;
        $data['timings_tab'] = $request->timings_tab;
        $booking = Booking::find($id);
        $booking->attended = 1;
        $booking->save();

        return redirect()->route('admins.bookings.index', ['bookings_tab' =>  $request->bookings_tab, 'timings_tab' => $request->timings_tab]);
    }

    public function absent($id,Request $request)
    {
        $booking = Booking::find($id);
        $booking->attended = 0;
        $booking->save();

        return redirect()->route('admins.bookings.index', ['bookings_tab' =>  $request->bookings_tab, 'timings_tab' => $request->timings_tab]);
    }

    public function cancel($id,Request $request)
    {
        $booking = Booking::find($id);
        $booking->status = "CANCELLED";
        $booking->save();
        $filter= "";
        $pushData = array(
            'message_en'=> $request->notes,
            'message_ar'=> $request->notes,
        );
        OneSignalHelper::notification(
            1,
            1, //user_id
            $booking->user->id, //user_id_to_notify
            "BOOKING_CANCELLED", //type
            "booking cancelled", // group
            $filter, // filter
            $pushData
        );

        return redirect()->route('admins.bookings.index', ['bookings_tab' =>  $request->bookings_tab, 'timings_tab' => $request->timings_tab]);
    }
}
