<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Competitions_time;
use Illuminate\Support\Facades\Auth;

class WebNotificationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function storeToken(Request $request)
    {
    $user = Auth::id();
    $u=User::where('id', $user)->update(['device_key' => $request->device_key]);
    return response()->json(['message' => 'Token successfully stored.']);
    }
   public function sendWebNotification(Request $request)
   {
        $url = 'https://fcm.googleapis.com/fcm/send';
       // $FcmToken = User::where('id',1)->pluck('device_key');

         $serverKey = 'AAAA9H2DmuM:APA91bEYm77LrislX0KVTlH3kd97BISNZcMhZKaxLRtUdeulPN5pGI3CgR3B12bwFLDqmQTd_xjk1Wc7V0ZJqzKRkZ78hiviQiEAy33dyYn8n35J2cBPaqhpE50yM2oE1gSsI0kM6hbO';

         $data = [
             "registration_ids" => $request->device_key,
             "notification" => [
                 "title" => 'Reminder notifications',
                 "body" =>'It is time to start your training',
             ]
         ];
         $encodedData = json_encode($data);

         $headers = [
             'Authorization:key=' . $serverKey,
             'Content-Type: application/json',
         ];

         $ch = curl_init();

         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
         // Disabling SSL Certificate support temporarly
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
         // Execute post
         $result = curl_exec($ch);
         if ($result === FALSE) {
             die('Curl failed: ' . curl_error($ch));
         }
        // // Close connection
         curl_close($ch);
        // // FCM response
         dd($result);
    }


    public function detect_competition_time(Request $request){
    Competitions_time::truncate();
    Competitions_time::create([
        'start_time' => $request->start_time,
        'end_time' => $request->end_time
    ]);

         $url = 'https://fcm.googleapis.com/fcm/send';
         $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();

        $serverKey = 'AAAA9H2DmuM:APA91bEYm77LrislX0KVTlH3kd97BISNZcMhZKaxLRtUdeulPN5pGI3CgR3B12bwFLDqmQTd_xjk1Wc7V0ZJqzKRkZ78hiviQiEAy33dyYn8n35J2cBPaqhpE50yM2oE1gSsI0kM6hbO';
          $time=Competitions_time::first();
         $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                 "title" => 'Reminder challenge',
                 "body" => 'Our application has a challenge. It will start in ' . $time->start_time . ' and end in ' . $time->end_time,
             ]
         ];
         $encodedData = json_encode($data);

         $headers = [
             'Authorization:key=' . $serverKey,
             'Content-Type: application/json',
         ];

         $ch = curl_init();

         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
         // Disabling SSL Certificate support temporarly
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
         // Execute post
         $result = curl_exec($ch);
         if ($result === FALSE) {
             die('Curl failed: ' . curl_error($ch));
         }
         // Close connection
         curl_close($ch);
         // FCM response
         dd($result);

     }
     //specific_time
     public function detect_time_byuser(Request $request){
        $id=Auth::id();
        Notification::create([
            'specific_time'=>$request->time,
            'user_id'=>$id

        ]);
     }



     public function get_detectedtime_byuser(){
        $f = [];
      $n=Notification::get();
      foreach ($n as $u){
        $userId = $u->user_id;
        $user=User::where('id',$userId)->first();
        if($user){
            $data=[

                'user_id'=>$u->user_id,
                'time'=>$u->specific_time,
                'device_key'=>$user->device_key,

            ];
            $f[] = $data;
        }
      }
      return response()->json($f);

     }










}




