<?php


namespace Modules\Proposal\App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user_id' =>$this->user_id,
            'reference_number' => $this->reference_number,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'preferred_name' => $this->preferred_name,
            'age' => $this->age,
            'gender' => $this->gender,
            'height' => $this->height,
            'civil_status' => $this->civil_status,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'nationality' => $this->nationality,
            'preferred_name' => $this->preferred_name,
            'religion' => $this->religion,
            'cast' => $this->cast,
            'profile_description' => $this->profile_description,
        ];

    }
}