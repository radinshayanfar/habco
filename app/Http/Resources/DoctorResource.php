<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isForThem = $request->user()->role === 'admin'
            || $this->user_id === $request->user()->id;
        return [
            'id' => $this->user_id,
            'specialization' => $this->specialization,
            $this->mergeWhen($isForThem, [
                'document_id' => $this->document_id,
                'cv_id' => $this->cv_id,
            ]),
            'user' => $this->when($this->relationLoaded('user'), $this->user->only(['fname', 'lname', 'phone'])),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
