<?php

namespace App\Helpers;
use App\Helpers\ArabicToEnglishConverter;

class SMSapp
{
    public static function sendSMS($args)
    {
        $phone = $args['phone'];
        $otp_code = $args['otp_code'];
        $phone = ArabicToEnglishConverter::convert($phone);
        $message = "كود التفعيل الخاص بكم لتطبيق واوان  : ".$otp_code."";
        $message = urlencode($message);
        $username = "";
        $password = "";
        $sender=config('app.name', 'Laravel');
        // $url = 'http://basic.unifonic.com/wrapper/sendSMS.php?appsid='.$appsid.'&msg='.$message.'&to='.$phone.'&baseEncode=False&encoding=UCS2';
        // $url = 'http://basic.unifonic.com/wrapper/sendSMS.php?msg='.$message.'&to='.$phone.'&sender='.$sender.'&baseEncode=False&encoding=UCS2';
        $url = 'http://www.oursms.net/api/sendsms.php?username=wawangym&password=1122335544&message='.$message.'&numbers='.$phone.'&sender='.$sender.'&unicode=E&return=full';
        \Log::debug(print_r($url, true));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Basic '. base64_encode("$username:$password"),
            ),
        ));
        
        $response = curl_exec($curl);
        \Log::debug(print_r($response, true));
        // var_dump($result); exit;
        curl_close($curl);
    }
}