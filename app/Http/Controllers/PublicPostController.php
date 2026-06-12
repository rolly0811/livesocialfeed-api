<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\WallPost;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function get($subscription_key) {
        $subscription = Subscription::where('subscription_key', $subscription_key);
        return view('/public/fb', ['subscription' => $subscription->first()]);
    }

    public function getPostPage($event_code) {
        $subscription = Subscription::where('event_code', $event_code);
        return view('/public/event-details', ['subscription' => $subscription->first()]);
    }
}
