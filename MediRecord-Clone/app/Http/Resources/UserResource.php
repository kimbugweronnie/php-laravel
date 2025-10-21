<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_id' => $this->user_id,
            'system_id' => $this->system_id,
            'username' => $this->username,
            'salt' => $this->salt,
            'secret_question' => $this->secret_question,
            'secret_answer' => $this->secret_answer,
            'creator' => $this->creator,
            'date_created' => $this->date_created,
            'changed_by' => $this->changed_by,
            'date_changed' => $this->date_changed,
            'retired' => $this->retired,
            'person_id' => $this->person_id,
            'retired_by' => $this->retired_by,
            'date_retired' => $this->date_retired,
            'retire_reason' => $this->retire_reason,
            'uuid' => $this->uuid,
            'activation_key' => $this->activation_key,
            'email' => $this->email,  
        ];
        
    }
}
