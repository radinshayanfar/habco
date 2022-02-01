<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientUserResource extends JsonResource
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
            'id' => $this->id,
            'fname' => $this->fname,
            'lname' => $this->lname,
            $this->mergeWhen($role !== 'pharmacist', [
                'address' => $this->address,
                'phone' => $this->phone,
                'age' => $this->age,
                'gender' => $this->gender,
            ]),
            $this->mergeWhen($role === 'patient' || $role === 'admin', [
                'email' => $this->email,
            ]),
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
