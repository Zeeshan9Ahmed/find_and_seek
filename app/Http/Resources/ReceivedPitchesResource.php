<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceivedPitchesResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'pitch_url' => $this->pitch_url,
            'user_id' => $this->user_id,
            'avatar' => $this->avatar,
            'full_name' => $this->full_name,
            'job_title' => $this->job_title,
        ];
    }
}
