<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'users';
    public $timestamps = true;
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_uuid',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'status',
        'gender'
    ];

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function invitationsSent()
    {
        return $this->hasMany(Invitation::class, 'sender_id');
    }

    public function invitationsReceived()
    {
        return $this->hasMany(Invitation::class, 'receiver_id');
    }
}
