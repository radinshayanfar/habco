<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstructionResource extends JsonResource
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
            'text' => $this->text,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'nurse' => new NurseResource($this->whenLoaded('nurse')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
