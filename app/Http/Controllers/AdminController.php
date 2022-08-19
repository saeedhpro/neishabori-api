<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchValuesResource;
use App\Interfaces\AttributeInterface;
use App\Interfaces\ProductInterface;
use App\Models\Attribute;

class AdminController extends Controller
{
    private ProductInterface $productRepository;
    private AttributeInterface $attributeRepository;

    public function __construct(ProductInterface $productRepository, AttributeInterface $attributeRepository)
    {
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
    }

    public function searchValues()
    {
        $attributes = $this->attributeRepository->noneEmptyList();
        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            $attribute['items'] = $attribute->items()->get()->unique('name');
        }
        return [
            'data' => [
                'min_price' => $this->productRepository->minPrice(),
                'max_price' => $this->productRepository->maxPrice(),
                'attributes' => $attributes,
            ]
        ];
    }
}
