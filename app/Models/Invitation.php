<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'proposal_id',
        'status'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function proposal(){
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
