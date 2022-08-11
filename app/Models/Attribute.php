<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    const SIMPLE_TYPE = 0;
    const VARIABLE_TYPE = 1;

    const COLOR_CATEGORY = 'color';
    const STRING_CATEGORY = 'string';
    const INTEGER_CATEGORY = 'integer';

    protected $fillable = [
        'name',
        'type',
        'category',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(AttributeItem::class);
    }
}
