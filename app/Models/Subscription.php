<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public function posts() {
        return $this->hasMany(WallPost::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function frames() {
        return $this->hasMany(Frame::class);
    }
}
