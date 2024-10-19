<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalEducational extends Model
{
    protected $fillable = [
        'proposal_id',
        'occupation',
        'industry',
        'company',
        'salary_range',
        'highest_education',
        'field_of_study',
        'institution'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
