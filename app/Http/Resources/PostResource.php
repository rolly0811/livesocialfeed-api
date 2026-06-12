<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $url = env('BASE_URL') . '/qr-code/' . $this->id . '/' . $this->unique_id;
        return [
            'id' => $this->id,
            'uid' => $this->unique_id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'company' => $this->company,
            'position' => $this->position,
            'message' => $this->message,
            'image' => $this->image,
            'approved' => $this->approved,
            'visible' => $this->visible,
            'background' => $this->background,
            'font_color' => $this->font_color,
            'qr_code' => 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $url,
            'created_at' => date('M d,Y h:iA', strtotime($this->created_at)),
            'code' => $this->subscription->event_code,
            'hash_tag' => $this->subscription->hash_tag,
            'show_timestamp' => $this->subscription->show_timestamp
        ];
    }
}
