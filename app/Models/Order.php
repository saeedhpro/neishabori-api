<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const CREATED_STATUS = "created";
    const IN_PROGRESS_STATUS = "in_progress";
    const DELIVERED_STATUS = "delivered";
    const RETURNED_STATUS = "returned";
    const CANCELED_STATUS = "canceled";

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
