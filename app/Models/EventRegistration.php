<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'partner_name',
        'registered_as',
        'details',
        'source',
        'biggest_challenge',
        'preferred_style',
        'receive_updates',
        'agreed_policy',
        'registration_code',
        'live_id',
        'attended_at',
        'target_date',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-M-Y H:i A',
        'attended_at' => 'datetime:d-M-Y H:i A'
    ];

    public function user() {
        return $this->belongsTo(EventRegisteredUser::class, 'user_id', 'id');
    }
}
