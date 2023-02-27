<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ClientResetPasswordNotification;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','nameBaby','ageBaby','class','user_id',
        'sexBaby','active','expireAt','birthBaby','bonus'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function challenges(){
        return $this->hasMany(Challenge::class);
    }

    public function sendPasswordResetNotification($token)
  {
      $this->notify(new ClientResetPasswordNotification($token));
  }

    public function doubts()
    {
        return $this->hasMany(Doubt::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
