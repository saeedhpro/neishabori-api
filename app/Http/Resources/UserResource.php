<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'sheba' => $this->sheba,
            'national_code' => $this->national_code,
            'job' => $this->job,
            'avatar' => $this->avatar,
            'is_legal' => $this->is_legal,
            'birth_date' => $this->birth_date,
            'organization' => $this->organization,
            'role' => $this->role,
            'is_admin' => $this->isAdmin(),
            'is_customer' => $this->isCustomer(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
