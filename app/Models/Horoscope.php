<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horoscope extends Model
{
    protected $table = 'horoscopes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'proposal_id',
        'birth_date',
        'birth_time',
        'birth_place',
        'lagnaya',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
