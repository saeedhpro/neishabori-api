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
        'brand_id',
        'seen',
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

    public function getIsSpecial()
    {
        return $this->query()->where('is_special', '=', true)
            ->where('id', '=', $this->id)
            ->where('special_start_date', '<=', Carbon::now())
            ->where('special_end_date', '>=', Carbon::now())->first() !== null;
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
        if (strlen($this->images) > 0) {
            return explode(',', $this->images);
        }
        return [];
    }

    public function getThumbnail()
    {
        if (strlen($this->images) > 0) {
            return explode(',', $this->images)[0];
        }
        return null;
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_id', 'id');
    }

    public function listAttributes($id)
    {
        $attributes = $this->attributes()->get();
        /** @var AttributeItem $att */
        foreach ($attributes as $att) {
            $att['item_list'] = $att->items()->where('product_id', $id)->get();
        }
        return $attributes;
    }

    public function listSimpleAttributes($id)
    {
        $attributes = $this->simpleAttributes()->get();
        /** @var AttributeItem $att */
        foreach ($attributes as $att) {
            $att['item_list'] = $att->items()->where('product_id', $id)->get();
        }
        return $attributes;
    }

    public function listVariableAttributes($id)
    {
        $attributes = $this->variableAttributes()->get();
        /** @var AttributeItem $att */
        foreach ($attributes as $att) {
            $att['item_list'] = $att->items()->where('product_id', $id)->get();
        }
        return $attributes;
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function attributeItems()
    {
        return $this->hasMany(AttributeItem::class);
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
        return $this->attributes()->where('category', '=', Attribute::COLOR_CATEGORY)->first();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
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
