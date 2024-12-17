<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $table = 'qualifications';

    protected $primaryKey = 'id';

    protected $fillable = [
        'proposal_id',
        'occupation',
        'industry',
        'company',
        'salary_range',
        'highest_education',
        'field_of_study',
        'institution',
        'other_details'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}