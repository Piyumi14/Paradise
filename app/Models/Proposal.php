<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'user_id',
        'reference_number',
        'first_name',
        'middle_name',
        'last_name',
        'preferred_name',
        'age',
        'gender',
        'height',
        'civil_status',
        'country_id',
        'province_id',
        'district_id',
        'area',
        'nationality',
        'religion',
        'cast',
        'profile_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function professionalEducational()
    {
        return $this->hasOne(ProfessionalEducational::class);
    }

    public function parents()
    {
        return $this->hasOne(Parents::class);
    }

    public function siblings()
    {
        return $this->hasMany(Sibling::class);
    }

    public function horoscope()
    {
        return $this->hasOne(Horoscope::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }
}
