<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
// use App\Model\OldClient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false, 'reset' => false]);
Route::get('/', 'HomeController@index')->name('home');
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('language/{locale}', 'HomeController@language')->name('language');

Route::middleware(['auth','csrf','role'])->group(function () {
    
    // Admin
    Route::group(['role' => ['ADMIN','EMPLOYEE'] ], function ()
    {
        Route::namespace('Dashboard\Admin')->prefix('admins')->name('admins.')->group(function()
        {
            Route::resource('dashboard','DashboardController');
            Route::resource('clients','ClientController');
            Route::resource('contact-us','ContactUsController');
            Route::resource('general-settings', 'GeneralSettingController');
            Route::resource('terms', 'TermsController');
            Route::resource('about-app', 'AboutAppController');
            Route::resource('social-media', 'SocialMediaController');
            Route::resource('faqs','FaqController');

            Route::get('requests/calls','RequestController@callRequestIndex')->name('requests.calls');
            Route::get('requests/chats','RequestController@chatRequestIndex')->name('requests.chats');
            Route::get('requests/emails','RequestController@emailRequestIndex')->name('requests.emails');
            Route::resource('requests','RequestController');
    
            Route::resource('advertisements','AdvertisementController');
            Route::resource('log-notifications','LogNotficationController');
        });

    });

});

Route::get('cron/early-call', 'CronNotifyController@fire_early_call')->name('cron.early-call');
// Route::get('cron/fire-expiration-notif-call', 'CronNotifyController@fire_expiration_notif_call')->name('cron.fire-expiration-notif-call');

// Route::get('/updatephones', function (){
//     $content = fopen(Storage::path('phones_new.txt'),'r');

//     while(!feof($content)){

//         $line = fgets($content);

//         // $phones .= $line;
//         // echo $line; exit;
//         $arr = explode(',',$line);
//         // echo $arr[1]." = ".date('Y-m-d',strtotime($arr[1])); exit;
//         OldClient::create(['phone'=>$arr[0], 'expiry_date'=> date('Y-m-d',strtotime($arr[1]))]);
//     }

//     fclose($content);
// });
