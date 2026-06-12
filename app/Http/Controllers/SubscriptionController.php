<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriptionRequest;
use App\Http\Resources\SubscriptionMedResource;
use App\Http\Resources\SubscriptionMinResource;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(Auth::user()->account_type == 'admin') {
            $subscriptions = Subscription::orderBy('start_date', 'ASC');
        }
        else if(Auth::user()->account_type == 'agent') {
            $subscriptions = Subscription::where('agent_id', Auth::user()->id)->orderBy('start_date', 'ASC');
        }
        else {
            $subscriptions = Subscription::where('user_id', Auth::user()->id)->orderBy('start_date', 'ASC');
        }
        

        return SubscriptionMedResource::collection($subscriptions->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubscriptionRequest $request)
    {
        $subscription = new Subscription();
        $subscription->user_id = Auth::user()->id;
        $subscription->event_code = $request->event_code;
        $subscription->theme = $request->theme;
        $subscription->hash_tag = $request->hash_tag;
        $subscription->start_date = date('Y-m-d', strtotime($request->start_date));
        $subscription->end_date = date('Y-m-d', strtotime($request->end_date));
        $subscription->enable_message_approval = $request->enable_message_approval;
        $subscription->subscription_key = md5(uniqid(rand(), true));
        $subscription->show_timestamp = $request->show_timestamp;
        $subscription->require_email = $request->require_email;
        $subscription->require_mobile = $request->require_mobile;
        $subscription->rotation_interval = $request->rotation_interval;
        $subscription->save();

        $subscription = Subscription::find($subscription->id);

        if($request->hasFile('background')) {
            $background = $request->file('background');
            $filename = 'background.' . $background->getClientOriginalExtension();
            $background->move(public_path('/uploads/subscriptions/' . $subscription->id), $filename);

            $subscription->background = $filename;
        }
        
        if($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = 'logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('/uploads/subscriptions/' . $subscription->id), $filename);

            $subscription->logo = $filename;
        }

        if($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $filename = 'banner.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('/uploads/subscriptions/' . $subscription->id), $filename);

            $subscription->banner = $filename;
        }


        $subscription->save();

        return $subscription;
    }

    /**
     * Show subscription details by code
     * @param string $code
     * @return \Illuminate\Http\Response
     */

     public function getDetailsByCode($code) {
        $subscription = Subscription::where('event_code', $code)->first();

        return new SubscriptionMinResource($subscription);
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
        $subscription = Subscription::find($id);
        $subscription->event_code = $request->event_code;
        $subscription->theme = $request->theme;
        $subscription->hash_tag = $request->hash_tag;
        $subscription->start_date = date('Y-m-d', strtotime($request->start_date));
        $subscription->end_date = date('Y-m-d', strtotime($request->end_date));
        $subscription->enable_message_approval = $request->enable_message_approval;
        $subscription->show_timestamp = $request->show_timestamp;
        $subscription->require_email = $request->require_email;
        $subscription->require_mobile = $request->require_mobile;
        $subscription->rotation_interval = $request->rotation_interval;

        if($request->hasFile('background')) {
            $background = $request->file('background');
            $filename = 'background.' . $background->getClientOriginalExtension();
            $background->move(public_path('/uploads/subscriptions/' . $subscription->id), $filename);

            $subscription->background = $filename;
        }
        
        if($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = 'logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('/uploads/subscriptions/' . $subscription->id), $filename);

            $subscription->logo = $filename;
        }

        if($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $filename = 'banner.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('/uploads/subscriptions/' . $subscription->id), $filename);

            $subscription->banner = $filename;
        }

        $subscription->save();

        return $subscription;
    }

    /**
     * Getting Subscription Details by Subscritpion Key
     * @param string $key subscription key
     * @return object
     */
    public function getSubscriptionByKey($key) {
        $subscription = Subscription::where('subscription_key', $key)->first();

        return new SubscriptionResource($subscription);
    }

    public function transferToClient($id, Request $request) {
        $subscription = Subscription::find($id);
        $subscription->user_id = $request->id;
        $subscription->save();

        return new SubscriptionResource($subscription);
    }
}
