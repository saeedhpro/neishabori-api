<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jcc\LaravelVote\Traits\Votable;

class Comment extends Model
{
    use HasFactory, Votable;

    const TYPE_ARTICLE = 'article';
    const TYPE_PRODUCT = 'product';

    protected $fillable = [
        'full_name',
        'type',
        'email',
        'body',
    ];
}
