<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyLoggedInResource extends JsonResource
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
            'email' => $this->email??"",
            'company_name' => $this->company_name??"",
            'role' => $this->role??"",
            'type' => "recruiter",
            'is_social'=>$this->is_social?1:0,
            'company_logo' => $this->company_logo??"",
            
            'profile_completed' => $this->profile_completed,
            'device_type' => $this->device_type??"",
            'device_token' => $this->device_token??"",
            'is_verified' => $this->email_verified_at?1:0,
        ];
    }
}
