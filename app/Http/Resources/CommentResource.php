<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'type' => $this->type,
            'body' => $this->body,
            'user' => new UserResource($this->user),
            'commentable' => $this->commentable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}