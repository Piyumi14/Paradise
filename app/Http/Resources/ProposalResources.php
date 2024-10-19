<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'tc_id' =>$this->tc_id,
            'version' => $this->version,
            'published_date' => $this->published_date,
            'status' => $this->status,
            'description' => $this->description,
            'row_version' => $this->row_version
        ];

    }
}
