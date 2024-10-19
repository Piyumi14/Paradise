<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horoscope extends Model
{
    protected $fillable = [
        'proposal_id',
        'birth_date',
        'birth_time',
        'birth_place',
        'lagnaya',
        'horoscope_details'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
