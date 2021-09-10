<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ClientSubscription;
use App\Model\Booking;


class SubscriptionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = ClientSubscription::all();
        $data['subscriptions'] = $subscriptions;
        return view('pages.admin.subscription-requests.index')->with(compact('data'));
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

    public function excelexport(Request $request)
    {
        $fileName = 'SubscriptionRequests.csv';
        $clientSubscriptions = ClientSubscription::all();

        $headers = array(
            "Content-Encoding" => " UTF-16LE",
            "Content-type" => "text/csv; charset=UTF-16LE",

            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",

        );

        $columns = array('Name', 'Phone', 'Duration', 'Message', 'Description', 'Preferred Time');

        $callback = function() use($clientSubscriptions, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $columns);

            foreach ($clientSubscriptions as $clientSubscription) {
                $row['Name']  = $clientSubscription->name;
                $row['Phone']    = $clientSubscription->phone;
                $row['Duration']  = $clientSubscription->duration->name_ar;
                $row['Message']    = $clientSubscription->message;
                $row['Description']  = $clientSubscription->description;
                $row['Preferred Time']  = __('lang.'.$clientSubscription->preferred_time);

                fputcsv($file, array($row['Name'], $row['Phone'], $row['Duration'], $row['Message'], $row['Description'], $row['Preferred Time']));
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
