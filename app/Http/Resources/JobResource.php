<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'job_type' => $this->job_type,
            'location' => $this->location,
            'from' => $this->from,
            'to' => $this->to,
            'salary_type' => $this->salary_type,
            'other' => $this->other?explode(',', $this->other):[],
            'user_id' => $this->user_id,
            'full_name' => $this->full_name,
            'representative_name' => $this->representative_name,
            'representative_avatar' => $this->representative_avatar,
            'avatar' => $this->avatar,
            'ptich_sent' => $this->ptich_sent,
            'role' => $this->role,

        ];
    }
}
