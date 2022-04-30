<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'service_id',
        'time',
        'city_id',
        'address',
        'plate',
        'phone_number',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
