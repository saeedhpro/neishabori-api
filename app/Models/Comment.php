<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jcc\LaravelVote\Traits\Votable;

class Comment extends Model
{
    use HasFactory, Votable;

    const TYPE_ARTICLE = 'article';
    const TYPE_PRODUCT = 'product';

    protected $fillable = [
        'type',
        'body',
        'user_id',
        'commentable_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): BelongsTo
    {
        switch ($this->type) {
            case Comment::TYPE_ARTICLE:
                return $this->article();
            case Comment::TYPE_PRODUCT:
                return $this->product();
        }
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'id', 'commentable_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id', 'commentable_id');
    }
}
