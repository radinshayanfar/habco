<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NurseResource extends JsonResource
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
            'document_id' => $this->document_id,
            'cv_id' => $this->cv_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
