<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address' => $this->address,
            'plate' => $this->plate,
            'uint' => $this->uint,
            'postal_code' => $this->postal_code,
            'recipient_first_name' => $this->recipient_first_name,
            'recipient_last_name' => $this->recipient_last_name,
            'recipient_phone_number' => $this->recipient_phone_number,
            'user' => $this->user,
            'city' => $this->city,
        ];
    }
}
