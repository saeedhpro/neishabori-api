<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'accept' => $this->accept,
            'question' => $this->question,
            'user' => $this->user,
            'parent' => $this->parent,
            'created_at' => $this->created_at,
        ];
    }
}
