<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndividualLoggedInResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->full_name??"",
            'avatar' => $this->avatar??"",
            'email' => $this->email??"",
            'role' => $this->role??"",
            'type' => "recruiter",
            'is_social'=>$this->is_social?1:0,
            'profile_completed' => $this->profile_completed,
            'device_type' => $this->device_type??"",
            'device_token' => $this->device_token??"",
            'is_verified' => $this->email_verified_at?1:0,
            'contact' => $this->contact??"",
            'address' => $this->address??"",
        ];
    }
}
