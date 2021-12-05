<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isForThem = $request->user()->role === 'admin'
            || $this->user_id === $request->user()->id;
        return [
            'id' => $this->user_id,
            'specialization' => $this->specialization,
            'document_id' => $this->when($isForThem, $this->document_id),
            'cv_id' => $this->when($isForThem, $this->cv_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
