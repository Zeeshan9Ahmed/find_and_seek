<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInUser extends JsonResource
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
            'full_name' => $this->full_name??"",
            'avatar' => $this->avatar??"",
            'email' => $this->email??"",
            'role' => $this->role??"",
            'contact' => $this->contact??"",
            'type' => $this->role=='user'?"user":"recruiter",
            'is_social'=>$this->is_social?1:0,
            'profile_completed' => $this->profile_completed,
            'device_type' => $this->device_type??"",
            'device_token' => $this->device_token??"",
            'is_verified' => $this->email_verified_at?1:0,
            'zip_code' => $this->zip_code??"",
            'resume_title' => $this->resume_title??"",
            'resume_description' => $this->resume_description??"",
            'user_resume' => $this->user_resume??"",
            'current_role' => $this->current_role??"",
            'address' => $this->address??"",
            'city' => $this->city??"",
            'state' => $this->state??"",
            'rep_avatar' => $this->representative_avatar??"",
            'rep_name' => $this->representative_name??"",
            'rep_email' => $this->representative_email??"",
            'rep_contact' => $this->representative_contact??"",
            'rep_address' => $this->representative_address??"",
            'job_title' => $this->job_title??"",
            'rep_city' => $this->representative_city??"",
            'rep_state' => $this->representative_state??"",
            'rep_zipCode' => $this->representative_zip_code??"",
            'company_employess' => $this->company_employess??"",
            'ideal_roles' => $this->ideal_roles?explode(',', $this->ideal_roles):[],
            'pitches' => UserPitchResource::collection($this->whenLoaded('pitches')),
            'rep_pitches' => UserPitchResource::collection($this->whenLoaded('rep_pitches')),
            'professions' => $this->professions,

        ];
    }
}
