<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $fillable = [
        'proposal_id',
        'father_nationality',
        'father_religion',
        'father_cast',
        'father_profession',
        'father_is_live',
        'mother_nationality',
        'mother_religion',
        'mother_cast',
        'mother_profession',
        'mother_is_live'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
