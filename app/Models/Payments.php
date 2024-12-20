<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payment_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'proposal_id',
        'receipt',
        'reference'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
