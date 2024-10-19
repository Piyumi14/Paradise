<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
    protected $fillable = [
        'proposal_id',
        'sibling_type',
        'civil_status'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
