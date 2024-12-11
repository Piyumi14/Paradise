<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserCredential extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'user_credentials';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $hidden = ['password'];

    protected $fillable = [
        'user_id',
        'user_name',
        'password'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
