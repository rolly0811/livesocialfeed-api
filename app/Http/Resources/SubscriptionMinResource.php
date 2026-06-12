<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionMinResource extends JsonResource
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
            'key' => $this->subscription_key,
            'theme' => $this->theme,
            'hash_tag' => $this->hash_tag,
            'show_timestamp' => $this->show_timestamp,
            'background' => $this->background . '?' . strtotime($this->updated_at),
            'banner' => $this->banner . '?' . strtotime($this->updated_at),
            'logo' => $this->logo . '?' . strtotime($this->updated_at),
            'start_date' => date('M d,Y', strtotime($this->start_date)),
            'end_date' => date('M d,Y', strtotime($this->end_date)),
            'qr_code' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . env('BASE_URL') . '/view-event/' . $this->event_code,
            'link' => env('BASE_URL') . '/view-event/' . $this->event_code,
            'require_email' => $this->require_email,
            'require_mobile' => $this->require_mobile,
            'rotation_interval' => $this->rotation_interval
        ];
    }
}
