<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone_number',
        'skill_id',
        'city_id',
        'address',
        'description',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
