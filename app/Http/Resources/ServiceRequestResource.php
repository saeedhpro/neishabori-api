<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
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
            'time' => $this->time,
            'plate' => $this->plate,
            'address' => $this->address,
            'city' => $this->city,
            'service' => $this->service,
        ];
    }
}
