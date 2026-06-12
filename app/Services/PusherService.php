<?php

namespace App\Services;
use Pusher\Pusher;
use Illuminate\Support\Facades\Log;

class PusherService
{
    public static function sendNotification($message, $type = 'approve') {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'), //key
            env('PUSHER_APP_SECRET'), //secret
            env('PUSHER_APP_ID'), //app_id
            $options
        );
        
        $data = (object) $message->toArray(request());
        $data->type = $type;
        
        Log::info(json_encode($data));
        return $pusher->trigger('my-channel', 'my-event', $data);
        
    }
}