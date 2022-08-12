<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sub_title' => $this->sub_title,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => new CategoryResource($this->category),
            'quantity' => $this->quantity,
            'sell_count' => $this->calcSellCount(),
            'price' => $this->calcPrice(),
            'rate' => $this->rating(),
            'special_start_date' => $this->special_start_date,
            'special_end_date' => $this->special_end_date,
            'is_special' => $this->is_special,
            'special_price' => $this->special_price,
            'likedByMe' => $this->likedByMe(),
            'images' => $this->getImages(),
            'related_products' => $this->relatedProducts,
            'attributes' => new AttributeProductCollectionResource($this->listAttributes($this->id)),
//            'colors' => $this->colorAttributes(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
