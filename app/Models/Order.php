<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const CREATED_STATUS = "created";
    const IN_PROGRESS_STATUS = "in_progress";
    const PAYED_STATUS = "payed";
    const DELIVERED_STATUS = "delivered";
    const RETURNED_STATUS = "returned";
    const CANCELED_STATUS = "canceled";

    protected $fillable = [
        'order_id',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faStatus()
    {
        switch($this->status) {
            case self::CREATED_STATUS:
                return 'ایجاد شده';
            case self::IN_PROGRESS_STATUS:
                return 'در حال پردازش';
            case self::PAYED_STATUS:
                return 'پرداخت شده';
            case self::DELIVERED_STATUS:
                return 'تحویل شده';
            case self::RETURNED_STATUS:
                return 'بازگشت به انبار';
            case self::CANCELED_STATUS:
                return 'لغو شده';
            default:
                return 'نامشخص';
        }
    }
}
