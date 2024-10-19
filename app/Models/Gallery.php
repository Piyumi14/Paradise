<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'proposal_id',
        'image_url',
        'is_main_photo'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
