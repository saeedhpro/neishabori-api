<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'title' => $this->title,
            'code' => $this->code,
            'type' => $this->type,
            'status' => $this->status,
            'value' => $this->value,
            'description' => $this->description,
            'limit' => $this->limit,
            'expired_at' => $this->expired_at,
            'expired' => $this->expired(),
        ];
    }
}
