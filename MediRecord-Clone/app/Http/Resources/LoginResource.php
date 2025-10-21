<?php

namespace App\Http\Resources;
use App\Models\UserRole;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'id' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'token' => $this->token ? $this->token:null,
            'role' => $this->role,
            'token_expiry' => $this->token_expiry
        ];
    }
}
