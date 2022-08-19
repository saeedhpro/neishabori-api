<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => new CategorySimpleResource($this->category),
            'brand' => $this->brand,
            'seen' => $this->seen,
            'quantity' => $this->quantity,
            'sell_count' => $this->calcSellCount(),
            'price' => $this->calcPrice(),
            'rate' => $this->rating(),
            'special_start_date' => $this->special_start_date,
            'special_end_date' => $this->special_end_date,
            'is_special' => $this->is_special,
            'special' => $this->getIsSpecial(),
            'special_price' => $this->special_price,
            'likedByMe' => $this->likedByMe(),
            'thumbnail' => $this->getThumbnail(),
            'images' => $this->getImages(),
            'related_products' => $this->relatedProducts,
            'attributes' => new AttributeProductCollectionResource($this->listAttributes($this->id)),
            'simple_attributes' => new AttributeProductCollectionResource($this->listSimpleAttributes($this->id)),
            'variable_attributes' => new AttributeProductCollectionResource($this->listVariableAttributes($this->id)),
            'colors' => $this->colorAttributes(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
