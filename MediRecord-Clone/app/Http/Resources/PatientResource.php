<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'creator' => $this->creator,
            'date_created' => $this->date_created,
            'changed_by' => $this->changed_by,
            'date_changed' => $this->date_changed,
            'voided' => $this->voided,
            'voided_by' => $this->voided_by,
            'date_voided' => $this->date_voided,
            'void_reason' => $this->void_reason,
            'allergy_status' => $this->allergy_status,
        ];
    }
}
