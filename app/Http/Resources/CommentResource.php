<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'type' => $this->type,
            'body' => $this->body,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'user' => new UserResource($this->user),
            'commentable' => $this->commentable,
            'parent' => $this->parent,
            'children' => new CommentCollectionResource($this->children),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
