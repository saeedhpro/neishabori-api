<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    const FIXED_TYPE = 'fixed';
    const PERCENTAGE_TYPE = 'percentage';

    const ENABLE_STATUS = 'enable';
    const DISABLE_STATUS = 'disable';

    protected $fillable = [
        'title',
        'code',
        'type',
        'status',
        'value',
        'description',
        'limit',
        'expired_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function expired()
    {
        return $this->expired_at !== null && Carbon::now()->isAfter(new Carbon($this->expired_at));
    }
}
