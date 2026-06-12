<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_code' => $this->event_code,
            'theme' => $this->theme,
            'hash_tag' => $this->hash_tag,
            'background' => '/uploads/subscriptions/' . $this->id . '/' . $this->background . '?' . strtotime($this->updated_at),
            'banner' => '/uploads/subscriptions/' . $this->id . '/' . $this->banner . '?' . strtotime($this->updated_at),
            'logo' => '/uploads/subscriptions/' . $this->id . '/' . $this->logo . '?' . strtotime($this->updated_at),
            'enable_message_approval' => $this->enable_message_approval,
            'show_timestamp' => $this->show_timestamp,
            'activated' => $this->activated,
            'start_date' => date('M d,Y', strtotime($this->start_date)),
            'end_date' => date('M d,Y', strtotime($this->end_date)),
            'created_at' => date('M d,Y h:iA', strtotime($this->created_at)),
            'updated_at' => date('M d,Y h:iA', strtotime($this->updated_at)),
            'posts' => $this->posts,
            'user' => $this->user,
            'subscription_key' => $this->subscription_key,
            'qr_code' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . env('BASE_URL') . '/view-event/' . $this->event_code,
            'link' => env('BASE_URL') . '/view-event/' . $this->event_code,
            'require_email' => $this->require_email,
            'require_mobile' => $this->require_mobile,
            'rotation_interval' => $this->rotation_interval,
        ];
    }
}
