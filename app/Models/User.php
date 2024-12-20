<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'email', 'phone', 'password'];
    
    protected $hidden = [
        'password',
        'remember_token',
        "last_reset_password_at"

    ];
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
