<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request)
    {
        return OrderResource::collection($this->collection);
    }
}
