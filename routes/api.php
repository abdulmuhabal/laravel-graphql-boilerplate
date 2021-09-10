<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware(['auth:api'])->group(function () {
    
//     Route::post('/photoUpload', function (Request $request) {

//         if(isset($request->photo))
//         {
//             $file = $request->photo;
//             $photo_file = array();
//             if($file)
//             {
//                 $fileName = 'photo_'.time().'.'.$file->getClientOriginalExtension();
//                 $file->storeAs('photos',$fileName);
//                 $photo_file['filename'] = $fileName;
//                 $photo_file['url'] = asset('photos/'.$fileName);
//             }
//             return array(
//                 "status" => 1,
//                 "message" => "Success",
//                 "photo" =>  $photo_file
//             );
//         }
        
//         return array(
//             "status" => 0,
//             "message" => "Cant upload image!",
//         ); 
//     });

// });
