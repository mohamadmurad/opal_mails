<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FcmController extends Controller
{

    public  function sendTo($data,$device_token=null,$title="FCMAPP",$body="FCMAPP BODY",$icon=null) {
        $notification = [
            'title' => $title,
            'body' => $body,
            'icon' => $icon,
        ];
        $notification = array_filter($notification, function($value) {
            return $value !== null;
        });
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
            'registration_ids' => $device_token,
            'notification' => $notification,
            'data'=>['fcmapp'=>$data]
        );
        $fields = json_encode ( $fields );
        $headers = array (
            'Authorization: key=' . env('FCMserver_key'),
            'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
}
