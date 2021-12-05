<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $role = $request->user()->role;
        return [
            'id' => $this->user_id,
            $this->mergeWhen($role === 'admin' || $role === 'doctor', [
                'covid_19' => $this->covid_19,
                'respiratory' => $this->respiratory,
                'infectious' => $this->infectious,
                'vascular' => $this->vascular,
                'cancer' => $this->cancer,
                'imuloical' => $this->imuloical,
                'diabetes' => $this->diabetes,
                'dangerous_area' => $this->dangerous_area,
                'pet' => $this->pet,
                'med_staff' => $this->med_staff,
            ]),
            'user' => new PatientUserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
