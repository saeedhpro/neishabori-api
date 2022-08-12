<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Product extends Model
{
    use HasFactory, Sluggable, Favoriteable;

    protected $fillable = [
        'title',
        'slug',
        'sub_title',
        'thumbnail',
        'description',
        'quantity',
        'price',
        'special_price',
        'is_special',
        'rate',
        'count',
        'images',
        'special_start_date',
        'special_end_date',
        'coupon_id',
        'category_id',
    ];

    protected $casts = [
        'is_special' => 'boolean',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function likedByMe(): bool
    {
        /** @var User $user */
        $user = auth('api')->user();
        /** @var Product $product */
        $product = Product::find($this->id);
        return $user && $user->hasFavorited($product);
    }

    public function getImages()
    {
        if (strlen($this->images)> 0) {
            return explode(',', $this->images);
        }
        return [];
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_id', 'id');
    }

    public function listAttributes($id)
    {
        $attributes = $this->attributes()->get();
        /** @var AttributeItem $att */
        foreach($attributes as $att) {
            $att['item_list'] = $att->items()->where('product_id', $id)->get();
        }
        return $attributes;
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function variableAttributes()
    {
        return $this->attributes()->where('type', '=', Attribute::VARIABLE_TYPE);
    }

    public function simpleAttributes()
    {
        return $this->attributes()->where('type', '=', Attribute::SIMPLE_TYPE);
    }

    public function colorAttributes()
    {
        return $this->attributes()->where('category', '=', Attribute::COLOR_CATEGORY)->first()->items;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function calcPrice()
    {
        return [
            "price" => $this->price,
            "discount" => 10,
            "discount_price" => 9000000,
        ];
    }

    public function calcSellCount()
    {
        return 0;
    }

    public function rating()
    {
        return [
            "rate" => $this->rate,
            "count" => $this->count
        ];
    }
}
