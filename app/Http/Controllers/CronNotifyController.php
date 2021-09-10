<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Helpers\OneSignalHelper;
use App\Model\LogNotification;
use App\Model\Booking;
use App\Model\Timing;


class CronNotifyController extends Controller
{
    public function fire_early_call()
    {
        // $today = date('H:i:s',strtotime('now +10 minutes'));
        echo date('H:i:00',strtotime('now +10 minutes'));
    
        $timings = Timing::where('start_time',date('H:i:00',strtotime('now +10 minutes')))->get();
        foreach ($timings as $key => $timing) {
            foreach ($timing->currentBookings() as $key => $booking) {
                if(!$booking->early_call){
                    $pushData = array(
                        'message_en'=> $timing->name_en,
                        'message_ar'=> $timing->name_ar,
                    );

                    OneSignalHelper::notification(
                        1,
                        1, //user_id
                        $booking->user->id, //user_id_to_notify
                        "EARLY_CALL", //type
                        "EARLY_CALL", // group
                        "", // filter
                        $pushData
                    );
                    $booking->early_call = true;
                    $booking->save();
                }
            }
            // echo "NAME: ".$timing->name_ar." = start: ". $start ." - today: ".  $today."<br/>"; exit;
        }
    }

    public function fire_expiration_notif_call()
    {
        $today = date('Y-m-d', strtotime('today +10 days'));
        // echo $today."<br>";

        $users = User::whereDate('expiry_date', date('Y-m-d', strtotime('today +10 days')))->get();
        // $users = User::all();
        
        foreach ($users as $key => $user) {
            // echo $user->name.": ".$user->expiry_date."<br>";
            if($user != NULL){
                OneSignalHelper::notification(
                    1,
                    1, //user_id
                    $user->id, //user_id_to_notify
                    "EXPIRATION_NOTIFICATION", //type
                    "EXPIRATION_NOTIFICATION", // group
                    "", // filter
                    ""
                );
            }
            // echo "NAME: ".$timing->name_ar." = start: ". $start ." - today: ".  $today."<br/>"; exit;
        }
    }
}
