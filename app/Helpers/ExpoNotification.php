<?php

namespace App\Helpers;
use App\Helpers\ArabiceToEnglishConverter;
use App\Model\LogNotification;
use App\User;

class ExpoNotification
{
    public static function callToNotify($user_id, $type, $user_id_to_notify)
    {
        $user_to_notify = User::find($user_id_to_notify);

        $title = "";

        switch ($type) {
            case 'YOU_GOT_EMAIL':
                $message_en="You got email reponse";
                $message_en="You got email reponse";
                break;
                case 'CHAT_REQUEST_APPROVED':
                    $message_en="Your chat request has been approved.";
                    $message_ar="Your chat request has been approved.";
                    break;
                    case 'CALL_REQUEST_APPROVED':
                        $message_en="Your call request has been approved.";
                        $message_ar="Your call request has been approved.";
                        break;
                        case 'EMAIL_REQUEST_APPROVED':
                            $message_en="Your email request has been approved.";
                            $message_ar="Your email request has been approved.";
                            break;

                
        }
        

        // $body = "{\"message\": \"".$message."\", \"message_ar\": \"".$message_ar."\"}";
        $body = $message_ar;
        $exponent_token = $user_to_notify->exponent_token;
        \Log::debug("user_TO_NOTIFY: ".$user_id_to_notify);
        $badge = self::getNumbersOfUnread($user_id_to_notify);

        self::sendNotification($title,$body,$exponent_token,$badge);

        self::logNotification($user_id, $message_en,$message_ar, $type, $user_id_to_notify);
    }

    public static function sendNotification($title,$body,$exponent_token)
    {

        // $exponent_token = "ExponentPushToken[".$exponent_token."]";
        // $exponent_token = $exponent_token;
        $postFields = "{\"to\": \"".$exponent_token."\",\"title\":\"".$title."\",\"body\": \"".$body."\",\"badge\": \"".$badge."\"}";
        // $postFields = "{\"to\": \"ExponentPushToken[nsG6PfCwBkrF2HUwdMtpSK]\",\"title\":\"fe%20aLKHEDMa\",\"body\": \"Your booking has been cancelled , please contact the management.\"}";
        
        // echo $postFields; exit;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$postFields,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
            \Log::debug('Error:' . curl_error($curl));
        }
        curl_close($curl);

        \Log::debug(print_r($response, true));
        
    }

    public static function logNotification($user_id, $message_en,$message_ar, $type, $user_id_to_notify){
        $logNotification = new LogNotification;
        $logNotification->user_id = $user_id;
        $logNotification->user_id_to_notify = $user_id_to_notify;
        $logNotification->type = $type;
        $logNotification->message_en = $message_en;
        $logNotification->read = 0;
        $logNotification->message_ar = $message_ar;
        
        $logNotification->save();

        // $user_to_notify = User::find($user_id_to_notify);
        // $user_to_notify->new_notif = true;
        // $user_to_notify->save();
    }

    public static function getNumbersOfUnread($user_id_to_notify){
        return LogNotification::where('user_id_to_notify',$user_id_to_notify)->where('read',0)->count() + 1;
    }
}