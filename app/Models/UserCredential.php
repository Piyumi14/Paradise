<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserCredential extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_credential';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',
        'username',
        'password'
    ];
}