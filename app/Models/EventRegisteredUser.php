<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegisteredUser extends Model
{
    use HasFactory;

    protected $fillable  = ['name', 'email', 'password', 'mobile', 'city', 'social', 'status'];

    public function registrations() {
        return $this->hasMany(EventRegistration::class, 'user_id', 'id');
    }
}
