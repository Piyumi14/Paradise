<?php


namespace Modules\Proposal\App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'reference_number' => $this->reference_number,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'preferred_name' => $this->preferred_name,
            'age' => $this->age,
            'height' => $this->height,
            'gender' => $this->gender,
            'district_id' => $this->district,
            'nationality' => $this->nationality,
            'religion' => $this->religion,
            'cast' => $this->cast,
            'job' => $this->professionalEducational,
            'gallery' => $this->gallery->map(function ($image) {
                return [
                    'id' => $image->id,
                    'proposal_id' => $image->proposal_id,
                    'image_url' => url('storage/images/' . $image->image_url), // Converts to http://localhost:8000/public/images/6762725031faa.jpg
                    'is_main_photo' => $image->is_main_photo,
                ];
            }),
        ];
    }
}
