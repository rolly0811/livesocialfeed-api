<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WallPost extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'company', 'position', 'message', 'subscription_id', 'mobile_no'];
    
    public function subscription() {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }
}
